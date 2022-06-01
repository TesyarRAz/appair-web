<?php

namespace App\DataTables\Admin;

use App\Models\Info;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class InfoDataTable extends DataTable
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
            ->editColumn('image', function($row) {
                $image = Storage::disk('public')->url($row->image);
                return <<< blade
                <img src="$image"' class="img-thumbnail" style="width: 200px; height: 200px;">
                blade;
            })
            ->editColumn('url', function($row) {
                $url = $row->url;

                return <<< blade
                <a href="$url" class="btn btn-link" target="_blank">$url</a>
                blade;
            })
            ->addColumn('aksi', function($row) {
                $id = $row->id;
                $csrf = csrf_field();
                $destroy = method_field('DELETE');

                $route_delete = route('admin.info.destroy', $id);

                return <<< blade
                <div>
                    <button type="button" class="btn btn-sm btn-primary" onclick="edit('$id')">Edit</button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="$('#form-delete-$id').submit()">Hapus</button>

                    <form class="d-none" action="$route_delete" method="POST" id="form-delete-$id" onsubmit="return confirm('Yakin ingin hapus transaksi?')">
                        $csrf
                        $destroy
                    </form>
                </div>
                blade;
            })
            ->rawColumns(['aksi', 'image', 'url']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Info $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return Info::query();
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
            Column::make('id')->title('ID'),
            Column::make('title')->title('Judul'),
            Column::computed('image'),
            Column::computed('url'),
            Column::computed('aksi')->exportable(false)->printable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Admin/Info_' . date('YmdHis');
    }
}
