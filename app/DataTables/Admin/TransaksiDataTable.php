<?php

namespace App\DataTables\Admin;

use App\Models\Transaksi;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TransaksiDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('bukti_bayar', function($row) {
                if (blank($row->bukti_bayar))
                {
                    return 'Tidak Ada';
                }

                $bukti_bayar = Storage::disk('public')->url($row->bukti_bayar);
                return <<< blade
                <img src="$bukti_bayar" alt="$bukti_bayar" width="200px" height="200px" class="img-thumbnail">
                blade;
            })
            ->addColumn('aksi', function($row) {
                $id = $row->id;
                $csrf = csrf_field();
                $delete = method_field('DELETE');

                $route_delete = route('admin.transaksi.destroy', $id);
                
                return <<< blade
                <div>
                    <button class="mb-1 btn btn-sm btn-primary" onclick="edit('$id')">
                        <i class="fa fa-pencil-alt"></i>
                        Edit
                    </button>
                    <button class="mb-1 btn btn-sm btn-danger" onclick="$('#form-delete-$id').submit()">
                        <i class="fas fa-fw fa-trash"></i>
                        Hapus
                    </button>
                    <form class="d-none" action="$route_delete" method="POST" id="form-delete-$id" onsubmit="return confirm('Yakin ingin hapus transaksi?')">
                        $csrf
                        $delete
                    </form>
                </div>
                blade;
            })
            ->rawColumns(['aksi', 'bukti_bayar']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Transaksi $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return Transaksi::select('transaksis.*')
        ->with('customer', 'customer.user:id,name')
        ->when(request()->has('status'), fn($query) => $query
            ->where('status', request()->status)
        )
        ->when(request()->has('from', 'to'), fn($query) => $query
            ->whereBetween('tanggal_bayar', [request()->from, request()->to])
        );
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->ajaxWithForm('', '#form-filter-status, #form-filter-tanggal')
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('print')
                        ->init('$(node).removeClass("dt-button")')
                        ->className('btn btn-sm btn-primary mb-2'),
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->title('ID'),
            Column::computed('customer.user.name')->title('Customer'),
            Column::make('total_harga')->title('Total Harga'),
            Column::computed('bukti_bayar'),
            Column::computed('aksi')->title('Aksi')->exportable(false)->printable(false)
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Transaksi_' . date('YmdHis');
    }
}
