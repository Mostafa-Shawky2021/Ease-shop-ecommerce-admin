<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\DataTables\admin\OrdersDataTable;

class OrderController extends Controller
{
    //
    public function index(OrdersDataTable $dataTable)
    {
        return $dataTable->render('orders.index');
    }
    public function create()
    {

    }
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }
    public function update(Request $request, Order $order)
    {

        $request->validate([
            'status' => 'integer|between:0,1'
        ]);
        $order->order_status = $request->input('status');

        if ($order->save()) {
            return redirect()->route('orders.index');
        }

    }

    public function deleteMultipleOrder(Request $request)
    {

        if ($request->ajax()) {

            $deletedCount = Order::whereIn('id', $request->input('id'))->delete();

            if ($deletedCount > 0) {

                return response([
                    'message' => 'orders deleted successfully'
                ], 200);

            }
            return response([
                'message' => 'no orders found'
            ], 404);
        }
    }
}