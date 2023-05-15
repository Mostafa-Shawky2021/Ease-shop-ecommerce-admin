<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\DataTables\admin\OrdersDataTable;
use App\Models\Order;
use APp\Models\Notification;

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
    public function show(Request $request, Order $order)
    {

        if ($request->boolean('is_seen')) {

            $order->notification()->update(['is_seen' => 1]);

            return redirect()->route('orders.show', ['order' => $order->id]);
        }
        return view('orders.show', compact('order'));
    }
    public function update(Request $request, Order $order)
    {

        $request->validate([
            'status' => 'integer|between:0,1'
        ]);
        $order->order_status = $request->input('status');

        if ($order->save()) {
            return redirect()->route('orders.index')
                ->with(['message' => ['تم تعديل حالة الاوردر بنجاح', 'success']]);
        }

    }

    public function destroy(Order $order)
    {
        $order->products()->detach();
        $order->notification()->delete();
        if ($order->delete()) {
            return redirect()->route('orders.index')
                ->with(['message' => ['تم حذف الاوردر بنجاح', 'warning']]);
        }
    }
    public function deleteMultipleOrder(Request $request)
    {

        if ($request->ajax()) {

            collect($request->input('id'))->each(function ($orderId) {
                $order = Order::find($orderId);
                if ($order) {
                    $order->products()->detach();
                    $order->notification()->delete();
                }
            });
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