<?php

namespace App\DataTables\admin;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

use Yajra\DataTables\Services\DataTable;

class ProductsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $name = 'mostafa';
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->setRowId('id')

            ->editColumn('image', function (Product $product) {
                return $product->image
                    ? "<img alt='product-image' src='/$product->image' width='50' height='50'/>"
                    : 'لا توجد صورة';
            })->editColumn('category', function (Product $product) {
            return $product->category->cat_name;
        })->editColumn('price_discount', function (Product $product) {
            return $product->price_discount ? $product->price_discount : 'لا يوجد  تخفيض';
        })->addColumn('action', function (Product $product) {
            $btn =
                '<div class="action-wrapper">
                 <a class="btn-action" href=' . route('products.edit', ['product' => $product->id]) . '>
                    <i class="fa fa-edit icon icon-edit"></i>
                 </a>
                 <form method="POST" action="' . route('products.delete', ['product' => $product->id]) . '"}}>
                    ' . method_field('delete') . '
                    <button class="btn-action">
                        <i class="fa fa-trash icon icon-delete"></i>
                    </button>
                 </form>
            </div>';
            return $btn;

        })->rawColumns(['image', 'action']);



    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->newQuery()
            ->with('category')
            ->select('products.*');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('products-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('frtip');
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('image')->title('صورة المنتج')->orderable(false),
            Column::make('product_name')->title('اسم المنتج'),
            Column::make('category')->name('category.cat_name')->title('القسم'),
            Column::make('price')->title('السعر'),
            Column::make('price_discount')->title('السعر بعد الخصم'),
            Column::make('action')->title('اجراء'),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Products_' . date('YmdHis');
    }
}