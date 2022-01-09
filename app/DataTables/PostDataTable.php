<?php

namespace App\DataTables;

use App\Models\Post;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PostDataTable extends DataTable
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
            ->addColumn('user', function(Post $post) {
                return '<a href="' . route('users.show', $post->user) .'">'. $post->user->name .'</a>';
            })
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" class="edit btn btn-info btn-sm">View</a>';
                $btn .= '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Edit</a>';
                $btn .= '<a href="javascript:void(0)" class="edit btn btn-danger btn-sm">Delete</a>';
                return $btn;
            })
            ->rawColumns(['user', 'action'])
            ->editColumn('caption', function(Post $post) {
                return Str::limit($post->caption, 15);
            })
            ->editColumn('created_at', function(Post $post) {
                return $post->created_at->format('g:i A, d M Y');
            })
            ->editColumn('updated_at', function(Post $post) {
                return $post->updated_at->format('g:i A, d M Y');
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Post $model)
    {
        return $model->newQuery()->with('user');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('post-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    )
                    ->scrollX(true);
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
            Column::computed('user')
                ->exportable(true)
                ->printable(true),
            Column::make('caption'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Post_' . date('YmdHis');
    }
}
