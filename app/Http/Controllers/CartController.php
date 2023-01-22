<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CartRequest;
use App\Models\Cart;

class CartController extends Controller
{
    //
    public function index(Request $request, $userId)
    {
        $carts = Cart::with('product')
            ->where('user_id', $userId)
            ->get();
        return response($carts);
    }
    public function store(CartRequest $request)
    {

        if ($request->validated()) {

            $cart = Cart::create([
                'user_id' => $request->input('user_id'),
                'product_id' => $request->input('product_id'),
                'size' => $request->input('size'),
                'color' => $request->input('color'),
                'quantity' => $request->input('quantity'),
                'unit_price' => $request->input('unit_price'),
                'total_price' => $request->input('total_price')
            ]);

            $carts = Cart::where('user_id', $request->input('user_id'))
                ->get();

            return response([
                'message' => 'Cart added successfully',
                'data' => $carts,
            ], 200);
        }

    }
    public function update(Request $request, $userId)
    {

        $updatedCart = Cart::where('user_id', $userId)
            ->get()
            ->map(function ($cart) use ($request) {
                $cart->user_id = $request->user()->id;
                $cart->save();
                return $cart;
            });

        if ($updatedCart->isNotEmpty()) {
            return response([
                'message' => 'Carts updated successfully',
                'data' => $updatedCart
            ], 200);
        }

        return response([
            'message' => 'no record updated',
        ], 200);

    }

    public function increaseProduct(Request $request, $productId, $userId)
    {
        $cart = Cart::with('product')
            ->where('product_id', $productId)
            ->where('user_id', $userId)
            ->first();

        $cart->quantity += 1;
        $cart->total_price = ($cart->quantity * $cart->unit_price);

        $cart->save();
        $carts = Cart::with('product')
            ->where('user_id', $userId)->get();

        return response([
            'message' => 'product increase successfully',
            'data' => $carts
        ], 200);

    }
    public function decreaseProduct(Request $request, $productId, $userId)
    {
        $cart = Cart::with('product')
            ->where('product_id', $productId)
            ->where('user_id', $userId)
            ->first();

        $cart->quantity -= 1;
        $cart->total_price = ($cart->quantity * $cart->unit_price);

        $cart->save();
        $carts = Cart::with('product')
            ->where('user_id', $userId)
            ->get();

        return response([
            'message' => 'product increase successfully',
            'data' => $carts
        ], 200);

    }
    public function destroy(Request $request, $cartId)
    {
        $cart = Cart::find($cartId);
        if ($cart) {
            $userId = $cart->user_id;

            $cart->delete();
            $carts = Cart::with('product')
                ->where('user_id', $userId)
                ->get();
            return response([
                'message' => 'Cart deleted successfully',
                'data' => $carts
            ]);
        }
        return response([
            'message' => 'There are no cart with secific id',
        ], 404);

    }
}