<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CartController;


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CheckoutController;


Route::get('/', [FrontendController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ReportController::class, 'index'])->name('admin.dashboard');

    Route::prefix('/food')->group(function () {
        Route::get('/', [FoodController::class, 'index'])->name('admin.food.index');
        Route::get('/create', [FoodController::class, 'create'])->name('admin.food.create');
        Route::post('/', [FoodController::class, 'store'])->name('admin.food.store');
        Route::get('/detail/{id}', [FoodController::class, 'detail'])->name('admin.food.detail');
        Route::get('/{id}/edit', [FoodController::class, 'edit'])->name('admin.food.edit');
        Route::put('/{id}', [FoodController::class, 'update'])->name('admin.food.update');
        Route::delete('/{id}', [FoodController::class, 'destroy'])->name('admin.food.destroy');
        Route::get('/trashed', [FoodController::class, 'trashed'])->name('admin.food.trashed');
        Route::put('/restore/{id}', [FoodController::class, 'restore'])->name('admin.food.restore');
    });

    Route::prefix('/order')->group(function () {
        Route::get('/trashed', [OrderController::class, 'trashed'])->name('admin.order.trashed');
        Route::put('/restore/{invoice_number}', [OrderController::class, 'restore'])->name('admin.order.restore');
        Route::get('/', [OrderController::class, 'index'])->name('admin.order.index');
        Route::get('/detail/{invoice_number}', [OrderController::class, 'detail']);
        Route::post('/', [OrderController::class, 'store'])->name('admin.orders.store');
        Route::get('/api/invoice-latest-number', [OrderController::class, 'getLatestInvoiceNumber']);
        Route::get('/{invoice_number}', [OrderController::class, 'show'])->name('admin.order.show');
        Route::get('/{invoice_number}/edit', [OrderController::class, 'edit'])->name('admin.order.edit');
        Route::put('/{invoice_number}', [OrderController::class, 'update'])->name('admin.order.update');
        Route::delete('/{invoice_number}', [OrderController::class, 'destroy'])->name('admin.order.destroy');
        Route::patch('/status/update/{invoice_number}', [OrderController::class, 'updateStatus'])->name('admin.order.updateStatus');
    });

    Route::prefix('/category')->group(function () {
        Route::get('/trashed', [CategoryController::class, 'trashed'])->name('admin.category.trashed');
        Route::put('/restore/{id}', [CategoryController::class, 'restore'])->name('admin.category.restore');
        Route::get('/', [CategoryController::class, 'index'])->name('admin.category.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('/', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('/{id}', [CategoryController::class, 'show'])->name('admin.category.show');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
    });
});

Route::get('/register', function () {
    return view('auth.register');
})->name('registerForm');

Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('loginForm');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Route untuk Customer
Route::get('/menus/category/{id}', [FrontendController::class, 'showByCategory'])->name('menus.byCategory');
Route::get('/menus/{id}', [FrontendController::class, 'show'])->name('menus.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
    Route::get('/cart/checkout', [CartController::class, 'checkoutForm'])->name('cart.checkout.form');
    Route::post('/cart/checkout', [CartController::class, 'processCheckout'])->name('cart.checkout.process');
    Route::get('/cart/edit/{id}', [CartController::class, 'edit'])->name('cart.edit');
    Route::post('/cart/update-ingredients/{id}', [CartController::class, 'updateIngredients'])->name('cart.update.ingredients');
});

Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my')->middleware('auth');




