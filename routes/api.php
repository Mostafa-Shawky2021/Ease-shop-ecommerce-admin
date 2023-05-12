<?php


use App\Http\Controllers\api\FavouriteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\LayoutController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\ProductVariantController;
use App\Http\Controllers\api\MessageController;


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


// Layout Resource
Route::controller(LayoutController::class)->group(function () {

	Route::get('/layout', 'index');

});



// Product Variants Resource
Route::controller(ProductVariantController::class)->group(function () {

	Route::get('/productvariants', 'index');
});

// Products Resource
Route::controller(ProductController::class)->group(function () {

	Route::get('/products', 'index');
	Route::get('/products/latestproducts', 'latestProduct');
	Route::get('/products/productslug/{product:product_slug}', 'show');
	Route::get('/products/productslug/{slug}/related', 'relatedProduct');
	Route::get('/search', 'searchProduct');
	Route::post('/products/recentview', 'recentView');
	Route::get('/products/random', 'randomProduct');
	Route::get('/products/offers', 'offersProduct');

});

// Categories Resource
Route::controller(CategoryController::class)->group(function () {

	Route::get('/categories', 'index');
	Route::get('/categories/products/random', 'randomCategoriesProducts');
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

	Route::get('/carts/user/{user}', 'index');
	Route::post('/carts', 'store');
	Route::put('/carts/user/{user}', 'update')->middleware('auth:sanctum');
	Route::put('/carts/{cart}/increment', 'increaseProduct');
	Route::put('/carts/{cart}/decrement', 'decreaseProduct');
	Route::delete('/carts/{cart}', 'destroy');

});

//Order Resource 
Route::controller(OrderController::class)->group(function () {
	Route::post('/orders/checkout', 'store');
	Route::post('/orders/checkout/fastorder', 'storeFastOrder');
});

// Contactus Resource
Route::post('/messages', [MessageController::class, 'store']);