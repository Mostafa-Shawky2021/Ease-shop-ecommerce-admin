<?php

namespace App\DataTables\admin;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Psy\Command\EditCommand;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

use Yajra\DataTables\Services\DataTable;


class CategoriesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action-muliple-wrapper', fn($category) => "<input value='" . $category->id . "'type='checkbox' class='action-checkbox'/>")
            ->editColumn('image', function (Category $category) {
                return $category->image
                    ? "<img alt='category-image' src='$category->image' width='30' height='30'/>"
                    : 'لا توجد صورة';

            })->editColumn('parent_category', function (Category $category) {
            return $category->parentCategory
                ? "<span>{$category->parentCategory->cat_name}</span>"
                : "لا يوجد قسم رئيسي";
        })->addColumn('action', function (Category $category) {
            $routeParamter = ['category' => $category->id];
            $btn =
                '<div class="action-wrapper">
                    <a class="btn-action" href=' . route('categories.edit', $routeParamter) . '>
                        <i class="fa fa-edit icon icon-edit"></i>
                    </a>
                    <form method="POST" action="' . route('categories.destroy', $routeParamter) . '"}}>
                        ' . method_field('DELETE') . '
                        ' . csrf_field() . '
                            <button class="btn-action" onclick="return confirm(\'هل انت متاكد؟\')">
                                <i class="fa fa-trash icon icon-delete"></i>
                        </button>
                    </form>
                </div>';
            return $btn;

        })->rawColumns(['action-muliple-wrapper', 'image', 'parent_category', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Category $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Category $model): QueryBuilder
    {
        return $model->newQuery()->with('parentCategory');

    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('categories-table')
            ->columns($this->getColumns())
            ->pageLength(15)
            ->minifiedAjax()
            ->dom('rtip')
            ->parameters(['order' => [1, 'desc']]);
        // ->selectStyleSingle();

    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('action-muliple-wrapper')->addClass('action-multiple-wrapper')->title('<input type="checkbox" id="multipleSelector" />')->orderable(false),
            Column::make('image')->title('صورة المنتج')->orderable(true)->className('image')->name('id'),
            Column::make('cat_name')->title('اسم القسم'),
            Column::make('parent_category')->title('القسم الرئيسي')->name('id'),
            Column::make('action')->title('اجراء')->orderable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Categories_' . date('YmdHis');
    }
}