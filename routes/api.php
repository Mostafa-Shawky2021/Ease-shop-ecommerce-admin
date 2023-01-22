<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;


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



// Products Resource
Route::controller(ProductController::class)->group(function () {
	Route::get('/products', 'index');
	Route::get('/products/latestproducts', 'latestProduct');
	Route::get('/products/name/{product}', 'show');


	Route::get('/search', 'searchProduct');
	Route::get('/products/{productId}/brand', 'relatedProduct');
	Route::post('/products/recentview', 'recentView');
	Route::get('/products/random', 'randomProduct');
	Route::get('/products/offers', 'offersProduct');

});

// Categories Resource
Route::controller(CategoryController::class)->group(function () {
	Route::get('/categories', 'index');
	Route::get('/categories/{category}', 'categoriesProducts');
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
	Route::post('/carts/{product}/users/{userid}/increase', 'increaseProduct');
	Route::post('/carts/{product}/users/{userid}/decrease', 'decreaseProduct');
	Route::delete('/carts/{cartId}', 'destroy');
});