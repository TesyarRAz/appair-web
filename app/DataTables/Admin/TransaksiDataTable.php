<?php

namespace App\DataTables\Admin;

use App\Models\Transaksi;
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
            ->addColumn('aksi', function($row) {
                $id = $row->id;
                $csrf = csrf_field();
                $delete = method_field('DELETE');

                $route_delete = route('admin.transaksi.destroy', $id);
                
                return <<< blade
                <div>
                    <button class="btn btn-sm btn-primary" onclick="edit('$id')">
                        <i class="fa fa-pencil-alt"></i>
                        Edit
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="$('#form-delete-$id').submit()">
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
            ->rawColumns(['aksi', 'status']);
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
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('print')
                        ->init('$(node).removeClass("dt-button")')
                        ->className('btn btn-sm btn-primary mb-2'),
                    )
                    ;
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
