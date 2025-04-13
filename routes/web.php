<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
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


Route::prefix('food')->group(function () {
    Route::get('/', [FoodController::class, 'index'])->name('foods.index');
    Route::get('/create', [FoodController::class, 'create'])->name('foods.create');
    Route::post('/', [FoodController::class, 'store'])->name('foods.store');
    Route::get('/{id}', [FoodController::class, 'show'])->name('foods.show');
    Route::get('/{id}/edit', [FoodController::class, 'edit'])->name('foods.edit');
    Route::put('/{id}', [FoodController::class, 'update'])->name('foods.update');
    Route::delete('/{id}', [FoodController::class, 'destroy'])->name('foods.destroy');
});

Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/{invoice_number}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/{invoice_number}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/{invoice_number}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/{invoice_number}', [OrderController::class, 'destroy'])->name('orders.destroy');
});

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/{id}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');

Route::get('/register', function () {
    return view('auth.register');
})->name('registerForm');

Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('loginForm');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/home', [HomeController::class, 'index'])->name('home');
