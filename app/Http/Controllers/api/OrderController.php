<?php

namespace App\Http\Controllers\api;

use App\Http\Requests\api\StoreOrderRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Traits\Invoice;
use App\Models\Cart;
use App\Models\User;
use App\Models\Notification;

class OrderController extends Controller
{
    use Invoice;

    public function index()
    {
    }
    public function store(StoreOrderRequest $request)
    {

        $guestId = $request->input('guest_id');

        $user = User::firstOrCreate(['guest_id' => $guestId]);

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
            // create new notification
            $notification = new Notification();
            $notification->message = 'تم عمل اوردر جديد باسم ' . $request->input('username');
            $order->notification()->save($notification);

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
        $guestId = $request->input('guest_id');

        $user = User::firstOrCreate(['guest_id' => $guestId]);

        $validatedInput = $request->safe()->merge([
            'invoice_number' => self::generateInvoice(),
            'total_price' => $request->input('total_price'),
            'user_id' => $user->id,

        ])->except('guest_id');


        $order = Order::create($validatedInput);

        if ($order) {
            $notification = new Notification();
            $notification->message = 'تم عمل اوردر جديد باسم ' . $request->input('username');
            $order->notification()->save($notification);

            $productId = $request->input('product_id');
            $quantity = $request->input('quantity');
            $order->products()->attach($productId, ['quantity' => $quantity]);
            return response([
                'message' => 'order created successfully',
                'data' => $order,
            ], 201);
        }
        return response(['message' => 'Error with creating order'], 422);
    }
}
