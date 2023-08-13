<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\api\StoreCartRequest;
use App\Models\Cart;

class CartController extends Controller
{
    //
    public function index(Request $request, $userId)
    {

        $carts = Cart::with(
            ['product' => fn ($queryBuilder) => $queryBuilder->withTrashed()]
        )->where('user_id', $userId)->get();

        return response($carts);
    }
    public function store(StoreCartRequest $request)
    {

        $validatedInputs = $request->validated();
        $cart = Cart::create($validatedInputs);

        if ($cart) {

            return response([
                'message' => 'Cart Added successfully',
                'data' => $cart->loadMissing('product')
            ], 201);
        }

        return response([
            'message' => 'Sorry There are error while adding new cart',
        ], 422);
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

    public function increaseProduct(Request $request, Cart $cart)
    {

        $cart->quantity += $request->has('quantity') ? $request->input('quantity') : 1;

        $cart->total_price = $cart->unit_price * $cart->quantity;

        if ($cart->save()) {
            return response([

                'message' => 'product increase successfully',
                'data' => $cart,

            ], 200);
        }

        return response([
            'message' => 'error while increase product'
        ], 422);
    }
    public function decreaseProduct(Request $request, Cart $cart)
    {

        if ($cart->quantity > 1) {

            $cart->quantity -= 1;

            $cart->total_price = $cart->unit_price * $cart->quantity;

            if ($cart->save()) {

                return response([
                    'message' => 'product decreased successfully',
                    'data' => $cart,
                ], 200);
            }
            return response([
                'message' => 'error while decrease product'
            ], 422);
        }

        $oldCartId = $cart->id;

        $isCartDeleted = $cart->delete();

        if ($isCartDeleted) {

            return response([
                'data' => ['deletedCartId' => $oldCartId],
                'message' => 'cart has been deleted  because it has reached the minimum value',
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
            'message' => 'There are no cart with secific id',
        ], 404);
    }
}
