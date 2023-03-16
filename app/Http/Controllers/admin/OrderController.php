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
}