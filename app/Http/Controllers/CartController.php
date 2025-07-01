<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
{
    $userId = auth()->id();
    $carts = Cart::with(['menu.images', 'ingredients.ingredient'])
                 ->where('users_id', $userId)
                 ->get();
    return view('cart', compact('carts'));
}

}
