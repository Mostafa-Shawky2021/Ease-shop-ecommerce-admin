<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Requests\CartRequest;
use App\Http\Controllers\Controller;

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

            if ($cart) {

                $cartWithProductData = $cart->with('product')->first();

                return response([

                    'Message' => 'Cart Added successfully',
                    'data' => $cartWithProductData

                ], 201);
            }
            return response([

                'Message' => 'Sorry There are error while adding new cart',

            ], 422);

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
            'Message' => 'no record updated',
        ], 200);

    }

    public function increaseProduct(Request $request, $cart)
    {

        $cart = Cart::find($cart);

        if (!$cart) {

            return response(['Message' => 'Sorry no cart found with specific id'], 404);
        }

        $cart->quantity += $request->has('quantity') ? $request->input('quantity') : 1;

        $cart->total_price = $cart->unit_price * $cart->quantity;

        $cart->save();

        return response([

            'Message' => 'product increase successfully',
            'data' => $cart,

        ], 200);

    }
    public function decreaseProduct(Request $request, $cart)
    {

        $cart = Cart::find($cart);

        if (!$cart) {

            return response([

                'Message' => 'Sorry no cart found with specific id'

            ], 404);

        }

        if ($cart->quantity > 1) {

            $cart->quantity -= 1;

            $cart->total_price = $cart->unit_price * $cart->quantity;

            $cart->save();

            return response([

                'Message' => 'product decreased successfully',
                'data' => $cart,

            ], 200);

        }
        $oldCartId = $cart->id;

        $cartDeletedStatus = $cart->delete();

        if ($cartDeletedStatus) {

            return response([
                'data' => ['deletedCartId' => $oldCartId],
                'Message' => 'cart has been deleted  because it has reached the minimum value',

            ], 200);
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

            ], 200);

        }

        return response([

            'Message' => 'There are no cart with secific id',

        ], 404);
    }
}