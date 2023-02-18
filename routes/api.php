<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductVariantController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });






// Product Variants
Route::controller(ProductVariantController::class)->group(function () {
	Route::get('/productvariants', 'index');
});

// Products Resource
Route::controller(ProductController::class)->group(function () {
	Route::get('/products', 'index');
	Route::get('/products/latestproducts', 'latestProduct');
	Route::get('/products/productslug/{slug}', 'show');
	Route::get('/products/productslug/{slug}/related', 'relatedProduct');

	Route::get('/search', 'searchProduct');

	Route::post('/products/recentview', 'recentView');
	Route::get('/products/random', 'randomProduct');
	Route::get('/products/offers', 'offersProduct');

});

// Categories Resource
Route::controller(CategoryController::class)->group(function () {
	Route::get('/categories', 'index');
	Route::get('/categories/random/products', 'randomCategories');
	Route::get('/categories/catslug/{slug}', 'categoryProducts');
	Route::get('/categories/{categroy}/subcategories', 'subCategories');
});



//Auth Resource
Route::controller(AuthController::class)->group(function () {
	Route::post('/login', 'authenticate');
	Route::post('/register', 'store');
});

//Cart Resource
Route::controller(CartController::class)->group(function () {
	Route::get('/carts/user/{userid}', 'index');
	Route::post('/carts', 'store');
	Route::put('/carts/user/{userid}', 'update')->middleware('auth:sanctum');
	Route::post('/carts/{cart}/increment', 'increaseProduct');
	Route::post('/carts/{cart}/decrement', 'decreaseProduct');
	Route::delete('/carts/{cartId}', 'destroy');
});

//Order Resource 
Route::controller(OrderController::class)->group(function () {
	Route::post('/orders/checkout', 'store');
	Route::post('/orders/checkout/fastorder', 'storeFastOrder');
});