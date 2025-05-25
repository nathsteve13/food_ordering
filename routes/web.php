<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/products', function () {
    return view('products.index');
});
Route::get('/products/{id}', [FoodController::class, 'show'])->name('products.show');


Route::get('/admin/dashboard', [ReportController::class, 'index'])->middleware(['auth'])->name('admin.dashboard');

// Tampilkan form konfirmasi pembayaran
Route::get('/transactions/confirm', [OrderController::class, 'show'])->name('transactions.confirm.form');

// Terima data form transaksi
Route::post('/transactions/confirm', [OrderController::class, 'store'])->name('transactions.confirm');

Route::prefix('admin/food')->group(function () {
    Route::get('/', [FoodController::class, 'index'])->name('admin.food.index');
    Route::get('/create', [FoodController::class, 'create'])->name('admin.food.create');
    Route::post('/', [FoodController::class, 'store'])->name('admin.food.store');
    
    // Routing untuk halaman detail produk

    Route::get('/{id}/edit', [FoodController::class, 'edit'])->name('admin.food.edit');
    Route::put('/{id}', [FoodController::class, 'update'])->name('admin.food.update');
    Route::delete('/{id}', [FoodController::class, 'destroy'])->name('admin.food.destroy');
    Route::get('/trashed', [FoodController::class, 'trashed'])->name('admin.food.trashed');
    Route::put('/restore/{id}', [FoodController::class, 'restore'])->name('admin.food.restore');
});

Route::prefix('admin/order')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('admin.order.index');
    Route::get('/create', [OrderController::class, 'create'])->name('admin.order.create');

    Route::get('/detail/{invoice_number}', [OrderController::class, 'detail']);

    Route::post('/', [OrderController::class, 'store'])->name('admin.orders.store');
    Route::get('/{invoice_number}', [OrderController::class, 'show'])->name('admin.order.show');
    Route::get('/{invoice_number}/edit', [OrderController::class, 'edit'])->name('admin.order.edit');
    Route::put('/{invoice_number}', [OrderController::class, 'update'])->name('admin.order.update');
    Route::delete('/{invoice_number}', [OrderController::class, 'destroy'])->name('admin.order.destroy');

    Route::patch('/status/update/{invoice_number}', [OrderController::class, 'updateStatus'])->name('admin.order.updateStatus');
});
Route::get('/admin/category/trashed', [CategoryController::class, 'trashed'])->name('admin.category.trashed');

Route::prefix('admin/category')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('admin.category.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::get('/{id}', [CategoryController::class, 'show'])->name('admin.category.show');
    Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::put('/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
    Route::put('/restore/{id}', [CategoryController::class, 'restore'])->name('admin.category.restore');
});

Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/register', function () {
    return view('auth.register');
})->name('registerForm');


Route::get('/login', function () {
    return view('auth.login');
})->name('loginForm');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/home', [HomeController::class, 'index'])->name('home');

//Menampilkan data report
Route::get('admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
