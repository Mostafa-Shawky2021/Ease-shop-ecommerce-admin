<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\ColorController;
use App\Http\Controllers\admin\SizeController;
use App\Http\Controllers\admin\BrandController;

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

    // User Resource
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
            Route::get('/categories/{category}/edit', 'edit')->name('categories.edit');
            Route::put('/categories/{category}', 'update')->name('categories.update');
            Route::delete('/categories/{category}', 'destroy')->name('categories.destroy');
        }
    );

    // Products Resource
    Route::controller(ProductController::class)->group(
        function () {
            Route::get('/products', 'index')->name('products.index');
            Route::get('/products/create', 'create')->name('products.create');
            Route::post('/products', 'store')->name('products.store');
            Route::get('/products/{product}/edit', 'edit')->name('products.edit');
            Route::put('/products/{product}', 'update')->name('products.update');
            Route::delete("/products/{product}", 'destroy')->name('products.destroy');
        }
    );

    // Order Resource
    Route::controller(OrderController::class)->group(
        function () {
            Route::get('/orders', 'index')->name('orders.index');
            Route::get('/orders/create', 'create')->name('orders.create');
            Route::get('/orders/{order}', 'show')->name('orders.show');
            Route::put('/orders/{order}', 'update')->name('orders.update');
            Route::delete('/orders/{order}', 'destroy')->name('orders.destroy');
        }
    );

    // Color Resource
    Route::controller(ColorController::class)->group(
        function () {
            Route::get('/colors', 'index')->name('colors.index');
            Route::get('/colors/create', 'create')->name('colors.create');
            Route::post('/colors', 'store')->name('colors.store');
            Route::get('/colors/{color}/edit', 'edit')->name('colors.edit');
            Route::put('/colors/{color}', 'update')->name('colors.update');
            Route::delete('/colors/{color}', 'destroy')->name('colors.destroy');
        }
    );

    //Size Resource
    Route::controller(SizeController::class)->group(
        function () {
            Route::get('/sizes', 'index')->name('sizes.index');
            Route::get('/sizes/create', 'create')->name('sizes.create');
            Route::post('/sizes', 'store')->name('sizes.store');
            Route::get('/sizes/{size}/edit', 'edit')->name('sizes.edit');
            Route::put('/sizes/{size}', 'update')->name('sizes.update');
            Route::delete('/sizes/{size}', 'destroy')->name('sizes.destroy');
        }
    );

    //Brand Resource
    Route::controller(BrandController::class)->group(
        function () {
            Route::get('/brands', 'index')->name('brands.index');
            Route::get('/brands/create', 'create')->name('brands.create');
            Route::post('/brands', 'store')->name('brands.store');
            Route::get('/brands/{brand}/edit', 'edit')->name('brands.edit');
            Route::put('/brands/{brand}', 'update')->name('brands.update');
            Route::delete('/brands/{brand}', 'destroy')->name('brands.destroy');
        }
    );

});