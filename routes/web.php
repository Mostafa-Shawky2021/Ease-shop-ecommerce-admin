<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (Request $request) {

    return view("dashboard.index");

});

Route::prefix('admin')->group(function () {

    // Use Resource
    Route::controller(UserController::class)->group(
        function () {
            Route::get('/users', 'index')->name('users.index');
            Route::get('/users/create', 'create')->name('users.create');
            Route::post('/users', 'store')->name('users.store');
        }
    );


    //Category Resource
    Route::controller(CategoryController::class)->group(
        function () {
            Route::get('/categories', 'index')->name('categories.index');
            Route::get('/categories/create', 'create')->name('categories.create');
            Route::post('/categories', 'store')->name('categories.store');
        }
    );

    // Products Resource
    Route::controller(ProductController::class)->group(
        function () {
            Route::get('/products', 'index')->name('products.index');
            Route::get('/products/create', 'create')->name('products.create');
            Route::post('/products', 'store')->name('products.store');
            Route::get('/products/{product}/edit', 'edit')->name('products.edit');
            Route::post('/products/{product}/update', 'update')->name('products.update');
            Route::delete("/products/{product}", 'delete')->name('products.delete');
        }
    );

    // Order Resource
    Route::controller(OrderController::class)->group(
        function () {
            Route::get('/orders', 'index')->name('orders.index');
            Route::get('/orders/create', 'create')->name('orders.create');
            Route::get('/orders/{order}', 'show')->name('orders.show');
            Route::put('/orders/{order}', 'update')->name('orders.update');
            Route::delete('/orders/{order}', 'delete')->name('orders.destroy');
        }
    );
});