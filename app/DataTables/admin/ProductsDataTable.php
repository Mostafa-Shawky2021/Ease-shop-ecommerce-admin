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

        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn(
                'action-muliple-wrapper',
                fn($product) => "<input value='" . $product->id . "'type='checkbox' class='action-checkbox'/>"
            )->editColumn('image', function (Product $product) {
                return $product->image
                    ? "<img alt='product-image' src='$product->image' width='30' height='30'/>"
                    : 'لا توجد صورة';
            })->editColumn(
                'category',
                fn(Product $product) => $product->category->cat_name ?? 'لا يوجد'

            )->editColumn('price', function (Product $product) {
                return number_format($product->price);
            })->editColumn('price_discount', function (Product $product) {
            return $product->price_discount
                ? $product->price_discount
                : 'لا يوجد  تخفيض';
        })->addColumn('action', function (Product $product) {

            $routeParamter = ['product' => $product->id];
            $productStatus = request()->query('status');

            // inject status query string if we in trashed page
            $routeParamter = $productStatus === 'trashed'
                ? array_merge($routeParamter, ['status' => 'trashed'])
                : $routeParamter;

            // if we in trashed page render resotre button
            $restoreBtn = $productStatus === 'trashed'
                ? "<form method='POST' action='" . route('products.restore', $routeParamter) . "'> 
                    " . csrf_field() . "
                    <button class='btn-action icon-restore' onclick='return confirm(\"هل انت متاكد؟\")'>
                        <i class='fa fa-rotate'></i>
                    </button>
                </form>"
                : "";

            // edit,restore,delete
            $actionbtns =
                '<div class="action-wrapper">
                    <a class="btn-action" href=' . route('products.edit', $routeParamter) . '>
                        <i class="fa fa-edit icon icon-edit"></i>
                    </a>
                    ' . $restoreBtn . '
                    <form method="POST" action="' . route('products.destroy', $routeParamter) . '"}}>
                        ' . method_field('DELETE') . '
                        ' . csrf_field() . '
                        <button class="btn-action" onclick="return confirm(\'هل انت متاكد؟\')">
                            <i class="fa fa-trash icon icon-delete"></i>
                        </button>
                    </form>
                </div>';
            return $actionbtns;

        })->rawColumns(['image', 'action', 'action-muliple-wrapper']);

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Product $model): QueryBuilder
    {
        $productStatus = request()->query('status');

        $modelBuilder = null;
        if ($productStatus === 'trashed') {
            $modelBuilder = $model->newQuery()->with('category')->select('products.*')->onlyTrashed();
        } else {
            $modelBuilder = $model->newQuery()->with('category')->select('products.*');
        }
        return $modelBuilder;
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
            ->parameters([
                'order' => [1, 'desc']
            ])->dom('rtip');
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {

        return [
            Column::make('action-muliple-wrapper')->addClass('action-multiple-wrapper')->title('<input type="checkbox" id="multipleSelector">')->orderable(false),
            Column::make('image')->title('صورة المنتج')->orderable(true)->name('id')->className('image'),
            Column::make('product_name')->title('اسم المنتج'),
            Column::make('category')->name('category.cat_name')->title('القسم'),
            Column::make('price')->title('السعر'),
            Column::make('price_discount')->title('السعر بعد الخصم'),
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
        return 'Products_' . date('YmdHis');
    }
}