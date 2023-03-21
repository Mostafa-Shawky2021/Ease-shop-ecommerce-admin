<?php

namespace App\Http\Controllers\api;

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
    public function store(Request $request)
    {

        $guestId = $request->input('guest_id');

        $user = User::where('guest_id', $guestId)->first();

        if (!$user) {
            $user = User::create([
                'guest_id' => $request->input('guest_id'),
            ]);

        }

        $guestUserCarts = Cart::where('user_id', $guestId)->get();

        // calc total price 
        $totalCartsPrice = 0;
        foreach ($guestUserCarts as $cart) {
            $totalCartsPrice += $cart->total_price;
        }

        $order = Order::create([
            'invoice_number' => self::generateInvoice(),
            'username' => $request->input('username'),
            'phone' => $request->input('phone'),
            'governorate' => $request->input('governorate'),
            'street' => $request->input('street'),
            'email' => $request->input('email'),
            'order_notes' => $request->input('order_notes'),
            'user_id' => $user->id,
            'total_price' => $totalCartsPrice
        ]);

        if ($order) {
            $guestUserCarts->map(function ($cart) use ($order) {
                $order->products()->attach($cart->product_id, ['quantity' => $cart->quantity]);
                $cart->delete();
            });
            return response(['message' => 'order created successfully'], 201);
        }

        return response(['message' => 'Error with creating order'], 422);
    }

    public function storeFastOrder(Request $request)
    {

        $guestId = $request->input('guest_id');

        $user = User::where('guest_id', $guestId)->first();

        if (!$user) {
            $user = User::create([
                'guest_id' => $request->input('guest_id'),
            ]);

        }

        $order = Order::create([
            'invoice_number' => self::generateInvoice(),
            'username' => $request->input('username'),
            'phone' => $request->input('phone'),
            'governorate' => $request->input('governorate'),
            'street' => $request->input('street'),
            'email' => $request->input('email'),
            'order_notes' => $request->input('order_notes'),
            'user_id' => $user->id,
            'total_price' => $request->input('total_price'),
        ]);

        if ($order) {
            $productId = $request->input('product_id');
            $quantity = $request->input('quantity');
            $order->products()->attach($productId, ['quantity' => $quantity]);
            return response(['Message' => 'order created successfully'], 201);
        }
        return response(['Message' => 'Error with creating order'], 422);


    }
}