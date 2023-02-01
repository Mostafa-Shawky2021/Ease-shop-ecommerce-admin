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

            $cart->product = $cart->product;
            if ($cart) {
                return response([
                    'message' => 'Cart Added successfully',
                    'data' => $cart
                ]);
            }

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

    public function increaseProduct(Request $request, $cart)
    {

        $cart = Cart::find($cart);

        if (!$cart) {
            return response(['message' => 'Sorry no cart found with specific id'], 404);
        }
        if ($request->has('quantity')) {
            $cart->quantity += $request->input('quantity');
        } else {
            $cart->quantity += 1;
        }
        $cart->total_price = $cart->unit_price * $cart->quantity;
        $cart->save();

        return response([
            'message' => 'product increase successfully',
            'data' => $cart,
        ], 200);

    }
    public function decreaseProduct(Request $request, $cart)
    {

        $cart = Cart::find($cart);
        if (!$cart) {
            return response(['message' => 'Sorry no cart found with specific id'], 404);
        }

        if ($cart->quantity > 1) {
            $cart->quantity -= 1;
            $cart->total_price = $cart->unit_price * $cart->quantity;
            $cart->save();
            return response([
                'message' => 'product decreased successfully',
                'data' => $cart,
            ], 200);
        } else {
            $cartStatus = $cart->delete();
            if ($cartStatus) {
                return response([
                    'message' => 'product has been deleted  because it has reached the minimum value',
                ]);
            }
        }

    }
    public function destroy(Request $request, $cartId)
    {
        $cart = Cart::find($cartId);
        if ($cart) {
            $cart->delete();
            return response([
                'message' => 'Cart deleted successfully',
                'data' => $cart
            ]);
        }
        return response([
            'message' => 'There are no cart with secific id',
        ], 404);
    }
}