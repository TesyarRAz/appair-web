<?php

namespace App\DataTables\Admin;

use App\Models\Customer;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CustomerDataTable extends DataTable
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
                $destroy = method_field('DELETE');

                $route_delete = route('admin.customer.destroy', $id);

                return <<< blade
                <div>
                    <button type="button" class="btn btn-sm btn-primary" onclick="edit('$id')">Edit</button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="$('#form-delete-$id').submit()">Hapus</button>

                    <form class="d-none" action="$route_delete" method="POST" id="form-delete-$id">
                        $csrf
                        $destroy
                    </form>
                </div>
                blade;
            })
            ->rawColumns(['aksi']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Customer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return Customer::select('customers.*')
        ->with('user');
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
                    ->minifiedAjax()
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
            Column::make('id'),
            Column::make('user.name')->title('Name'),
            Column::make('user.email')->title('Email'),
            Column::make('user.username')->title('Username'),
            Column::computed('aksi'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Admin/Customer_' . date('YmdHis');
    }
}
