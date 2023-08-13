<?php

namespace App\DataTables\admin;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

use Yajra\DataTables\Services\DataTable;

class OrdersDataTable extends DataTable
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
            ->setRowId('id')
            ->addColumn('action-muliple-wrapper', fn ($order) => "<input value='" . $order->id . "'type='checkbox' class='action-checkbox'/>")
            ->editColumn('invoice_number', function ($order) {
                $orderRoute = ['order' => $order->id];
                return "<a href='" . route('orders.show', $orderRoute) . "'>$order->invoice_number</a>";
            })
            ->editColumn(
                'created_at',
                function ($order) {

                    $orderDate = $order->created_at->format('Y-m-d');
                    return $orderDate;
                }
            )->editColumn(
                'total_price',
                fn ($order) => number_format($order->total_price)

            )->editColumn(
                'order_status',
                function ($order) {

                    $btn = '';
                    if ($order->order_status === 0) {
                        $btn = '<div class="status  pending">معلق</div>';
                    }
                    if ($order->order_status === 1) {
                        $btn = '<div class="status processing">يتم التحضير</div>';
                    }
                    return $btn;
                }
            )->addColumn(
                'action',
                function ($order) {

                    $orderRoute = ['order' => $order->id];
                    $btns = '
                    <div class="action-wrapper">
                        <a href="' . route('orders.show', $orderRoute) . '" class="text-primary">
                            <i class="fa fa-eye"></i>
                        </a>
                        <form method="POST" action=' . route('orders.destroy', $orderRoute) . '>
                        ' . csrf_field() . '   
                        ' . method_field("DELETE") . '
                            <button class="btn-action" onclick="return confirm(\'هل انت متاكد؟!\')">
                                <i class="fa fa-trash icon icon-delete"></i>
                            </button> 
                        </form>
                    </div>';
                    return $btns;
                }
            )->rawColumns(['action', 'order_status', 'invoice_number', 'action-muliple-wrapper']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model): QueryBuilder
    {
        $queryBuilderModel = null;
        $orderStatus = request()->query('status');

        $queryBuilderModel = $orderStatus === 'completed'
            ? $model->newQuery()->where('order_status', 1)
            : $model->newQuery()->where('order_status', 0);

        return $queryBuilderModel;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('orders-table')
            ->columns($this->getColumns())
            ->pageLength(15)
            ->minifiedAjax()
            ->dom('rtip')->ajax([
                'headers' => ['X-Requested-With' => 'XMLHttpRequest']
            ])->parameters([
                'order' => [1, 'desc']
            ]);
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
            Column::make('invoice_number')->title('رقم الفاتورة')->name('id')->orderable(true),
            Column::make('governorate')->title('المحافظة'),
            Column::make('street')->title('عنوان الشارع'),
            Column::make('total_price')->title('اجمالي السعر'),
            Column::make('created_at')->title('التاريخ'),
            Column::make('order_status')->title('الحالة'),
            Column::make('action')->title('اجراء')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Orders_' . date('YmdHis');
    }
}
