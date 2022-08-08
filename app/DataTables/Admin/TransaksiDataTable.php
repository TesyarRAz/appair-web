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
            ->editColumn('tanggal_bayar', function($row) {
                return optional($row->tanggal_bayar)->format('d-m-Y') ?? '-';
            })
            ->editColumn('tanggal_tempo', function($row) {
                $date = optional($row->tanggal_tempo)->isoFormat('MMMM Y') ?? '-';

                return <<< blade
                <span class="badge badge-danger">
                $date
                </span>
                blade;
            })
            ->editColumn('total_harga', function($row) {
                return 'Rp. '.number_format($row->total_harga, 0, ',', '.');
            })
            ->addColumn('aksi', function($row) {
                $id = $row->id;

                $csrf = csrf_field();
                $delete = method_field('delete');
                
                $route_delete = route('admin.transaksi.destroy', $id);
                $route_invoice = route('admin.transaksi.show', ['transaksi' => $id, 'type' => 'invoice']);

                if (in_array(request()->status, ['belum_bayar', 'diterima']))
                {
                    $btn_edit = <<< blade
                    <button class="mb-1 btn btn-sm btn-primary" onclick="edit('$id')">
                        <i class="fa fa-money-bill"></i>
                        Bayar
                    </button>
                    blade;
                }
                else
                {
                    $btn_edit = <<< blade
                    <button class="mb-1 btn btn-sm btn-primary" onclick="edit('$id')">
                        <i class="fa fa-pencil-alt"></i>
                        Edit
                    </button>
                    blade;
                }

                if (request()->status == 'lunas')
                {
                    $btn_invoice = <<< blade
                    <a class="mb-1 btn btn-sm btn-success" href="$route_invoice">
                        <i class="fas fa-book"></i>
                        Invoice
                    </a>
                    blade;
                }
                else
                {
                    $btn_invoice = '';
                }
                
                return <<< blade
                $btn_edit
                <button class="mb-1 btn btn-sm btn-danger d-none" onclick="$('#form-delete-$id').submit()">
                    <i class="fas fa-fw fa-trash"></i>
                    Hapus
                </button>
                $btn_invoice
                <form class="d-none" action="$route_delete" method="POST" id="form-delete-$id" onsubmit="return confirm('Yakin ingin hapus transaksi?')">
                    $csrf
                    $delete
                </form>
                blade;
            })
            ->addIndexColumn()
            ->rawColumns(['tanggal_tempo', 'aksi', 'bukti_bayar']);
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
        ->when(request()->filled('from', 'to'), fn($query) => $query
            ->whereBetween('tanggal_tempo', [request()->from, request()->to])
        )
        ->join('customers', 'customers.id', '=', 'transaksis.customer_id')
        ->join('users', 'users.id', '=', 'customers.user_id')
        ->orderBy('users.name');
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
            Column::computed('DT_RowIndex', 'No'),
            Column::make('customer.user.name')->title('Customer'),
            Column::make('tanggal_tempo'),
            Column::make('tanggal_bayar'),
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
