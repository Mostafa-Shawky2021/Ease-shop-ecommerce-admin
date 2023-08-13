<?php

use App\Http\Controllers\admin\Auth\LoginController;
use App\Http\Controllers\admin\NotificationController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\LayoutHomepageCarouselController;
use App\Http\Controllers\admin\LayoutHomepageFooterController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\ColorController;
use App\Http\Controllers\admin\SizeController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\MessageController;
use App\Http\Controllers\admin\ProfileController;

use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\UrlGenerator;
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


Route::get('/', function () {

    return Redirect::to('/admin');
});
Route::prefix('admin')->group(function () {

    // Dashboard
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'create'])->name('login');
        Route::post('/login', [LoginController::class, 'auth'])->name('login.auth');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/', function (Request $request) {
            $productsCount = Product::count();
            $pendingOrders = Order::where('order_status', 0)->count();
            $completedOrders = Order::where('order_status', 1)->count();
            $categoriesCount = Category::count();
            $latestOrders = Order::where('order_status', 0)
                ->limit(15)
                ->get();
            return view(
                "dashboard.index",
                compact(
                    'productsCount',
                    'pendingOrders',
                    'completedOrders',
                    'categoriesCount',
                    'latestOrders'
                )
            );
        })->name('dashboard');

        //profile
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

        //Layout Resources
        Route::resource('layout/homepage/carousel', LayoutHomepageCarouselController::class)
            ->except(['show']);

        Route::resource('layout/homepage/footer', LayoutHomepageFooterController::class)
            ->except(['show']);

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
                Route::post('/categories/delete', 'deleteMultipleCategories')->name('categories.deleteMultiple');
            }
        );

        // Products Resource
        Route::controller(ProductController::class)->group(
            function () {
                // if contain ?staus=trashed will show trashed products
                Route::get('/products', 'index')->name('products.index');
                Route::get('/products/create', 'create')->name('products.create');
                Route::post('/products', 'store')->name('products.store');
                Route::get('/products/{product}/edit', 'edit')->name('products.edit')->withTrashed();
                Route::put('/products/{product}', 'update')->name('products.update')->withTrashed();

                // if contain ?status=trashed will delete product permanently
                Route::delete("/products/{product}", 'destroy')->name('products.destroy')
                    ->withTrashed();
                Route::post('/products/{product}/restore', 'restoreProduct')->name('products.restore')->withTrashed();
                Route::post('/products/restore', 'restoreMultipleProducts')->name('products.restoreMultiple')->withTrashed();
                Route::post('/products/delete', 'deleteMultipleProducts')->name('products.deleteMultiple');
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
                Route::post('/orders/delete', 'deleteMultipleOrder')->name('orders.deleteMultiple');
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
                Route::post('/colors/delete', 'deleteMultipleColor')->name('colors.deleteMultiple');
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
                Route::post('/sizes/delete', 'deleteMultipleSizes')->name('sizes.deleteMultiple');
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
                Route::post('/brands/delete', 'deleteMultipleBrands')->name('brands.deleteMultiple');
            }
        );
        // Notification Resource
        Route::controller(NotificationController::class)->group(
            function () {
                Route::get('/notifications', 'index')->name('notifications.index');
                Route::delete('/notifications/{notification}', 'destroy')->name('notifications.destroy');
                Route::put('/notifications/{notification}', 'update')->name('notifications.update');
                Route::post('/notifications/delete', 'deleteMultipleNotifications')->name('notifications.deleteMultiple');
            }
        );

        // Message Resource
        Route::apiResource('messages', MessageController::class)->except(['update', 'store']);
        Route::post('/messages/delete', [MessageController::class, 'deleteMultipleMessages'])->name('messages.deleteMultiple');
    });
});
