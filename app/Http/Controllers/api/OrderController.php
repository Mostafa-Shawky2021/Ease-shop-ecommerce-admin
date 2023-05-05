<?php

namespace App\Http\Controllers\api;

use App\Http\Requests\api\StoreOrderRequest;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Traits\Invoice;
use App\Models\User;
use App\Models\Cart;

class OrderController extends Controller
{
    use Invoice;

    public function index()
    {

    }
    public function store(StoreOrderRequest $request)
    {

        $guestId = $request->input('guest_id');

        $user = User::firstWhere('guest_id', $guestId);

        // if user dosen't exist create one so we can make realtion with order data
        if (!$user) {
            $user = User::create([
                'guest_id' => $request->input('guest_id'),
            ]);

        }

        $guestUserCarts = Cart::where('user_id', $guestId)->get();

        // calc total price 
        $totalCartsPrice = 0;

        foreach ($guestUserCarts as $cart)
            $totalCartsPrice += $cart->total_price;

        // merge the order details with 
        $validatedInputs = $request->safe()->merge([
            'invoice_number' => self::generateInvoice(),
            'user_id' => $user->id,
            'total_price' => $totalCartsPrice
        ])->except('guest_id');

        $order = Order::create($validatedInputs);

        if ($order) {

            Notification::create([
                'message' => 'تم عمل اوردر جديد باسم ' . $request->input('username'),
                'status' => 1,
                'order_id' => $order->id
            ]);
            $guestUserCarts->map(
                function ($cart) use ($order) {
                    $order->products()->attach($cart->product_id, ['quantity' => $cart->quantity]);
                    $cart->delete();
                }
            );
            return response([
                'message' => 'order created successfully',
                'data' => $order
            ], 201);
        }

        return response(['message' => 'Error with creating order'], 422);
    }

    public function storeFastOrder(StoreOrderRequest $request)
    {

        $validatedInput = $request->safe()->merge([
            'total_price' => $request->input('total_price'),
        ])->except('guest_id');

        $guestId = $request->input('guest_id');

        $user = User::where('guest_id', $guestId)->first();

        if (!$user) {
            $user = User::create([
                'guest_id' => $request->input('guest_id'),
            ]);

        }
        $order = Order::create($validatedInput);

        if ($order) {
            Notification::create([
                'message' => 'تم عمل اوردر جديد باسم ' . $request->input('username'),
                'status' => 0,
            ]);
            $productId = $request->input('product_id');
            $quantity = $request->input('quantity');
            $order->products()->attach($productId, ['quantity' => $quantity]);
            return response([
                'Message' => 'order created successfully',
                'data' => $order,
            ], 201);
        }
        return response(['Message' => 'Error with creating order'], 422);


    }
}