<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartIngredients;
use App\Models\Menu;
use App\Models\OrderType;
use App\Models\PaymentType;
use App\Models\Transaction;
use App\Models\DetailTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $cartItems = Cart::with(['menu.images', 'ingredients.ingredient'])
            ->where('users_id', $userId)
            ->get();

        $total = $cartItems->sum(fn($item) => $item->menus_price * $item->quantity);

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, $menuId)
    {
        $menu = Menu::findOrFail($menuId);
        $userId = auth()->id();

        $cart = Cart::firstOrNew([
            'users_id' => $userId,
            'menus_id' => $menuId,
        ]);

        $cart->menus_price = $menu->price;
        $cart->quantity = $cart->exists ? $cart->quantity + 1 : 1;
        $cart->save();

        $ingredientIds = $request->input('ingredients', []);
        foreach ($ingredientIds as $menuHasIngredientId) {
            if (!empty($menuHasIngredientId)) {
                CartIngredients::create([
                    'cart_id' => $cart->id,
                    'menu_has_ingredient_id' => $menuHasIngredientId,
                ]);
            }
        }

        return redirect()->route('cart.index')->with('success', 'Item added to cart!');
    }

    public function updateQuantity(Request $request)
    {
        $cartId = $request->input('id');
        $quantity = (int) $request->input('quantity');

        $cart = Cart::find($cartId);

        if (!$cart || $cart->users_id !== auth()->id()) {
            return redirect()->route('cart.index')->with('error', 'Unauthorized');
        }

        $cart->quantity = max($quantity, 1);
        $cart->save();

        return redirect()->route('cart.index')->with('success', 'Quantity updated');
    }

    public function remove($id)
    {
        $cart = Cart::findOrFail($id);

        if ($cart->users_id !== auth()->id()) {
            abort(403);
        }

        $cart->ingredients()->detach();
        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed.');
    }

    public function checkoutForm()
    {
        $userId = auth()->id();
        $cartItems = Cart::with(['menu', 'ingredients.ingredient'])->where('users_id', $userId)->get();

        $total = $cartItems->sum(fn($item) => $item->menus_price * $item->quantity);

        // Karena order_type dan payment_type adalah enum
        $orderTypes = ['dinein', 'takeaway'];
        $paymentTypes = ['qris', 'credit', 'debit', 'e-wallet'];

        return view('cart.checkout', compact('cartItems', 'orderTypes', 'paymentTypes', 'total'));
    }


    public function processCheckout(Request $request)
    {
        $userId = auth()->id();

        $request->validate([
            'order_type_id' => 'required|exists:order_types,id',
            'payment_type_id' => 'required|exists:payment_types,id',
        ]);

        $cartItems = Cart::with('ingredients')->where('users_id', $userId)->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty.');
        }

        $transaction = Transaction::create([
            'users_id' => $userId,
            'total_price' => $cartItems->sum(fn($item) => $item->menus_price * $item->quantity),
            'order_type_id' => $request->order_type_id,
            'payment_type_id' => $request->payment_type_id,
        ]);

        foreach ($cartItems as $item) {
            $detail = DetailTransaction::create([
                'transactions_id' => $transaction->id,
                'menus_id' => $item->menus_id,
                'quantity' => $item->quantity,
                'price' => $item->menus_price,
            ]);

            foreach ($item->ingredients as $ingredient) {
                $detail->ingredients()->attach($ingredient->menu_has_ingredient_id);
            }
        }

        foreach ($cartItems as $item) {
            $item->ingredients()->detach();
            $item->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Checkout berhasil!');
    }
    public function edit($id)
    {
        $cartItem = Cart::with('menu.ingredients', 'ingredients')->findOrFail($id);

        if ($cartItem->users_id !== auth()->id()) {
            abort(403);
        }

        return view('cart.update', compact('cartItem'));
    }

    public function updateIngredients(Request $request, $id)
    {
        $cartItem = Cart::with('ingredients')->findOrFail($id);

        if ($cartItem->users_id !== auth()->id()) {
            abort(403);
        }

        // Hapus semua cart ingredients lama
        CartIngredients::where('cart_id', $cartItem->id)->delete();

        $ingredientIds = $request->input('ingredients', []);

        // Validasi apakah ingredients ada di tabel menus_has_ingredients
        $validIds = DB::table('menus_has_ingredients')
            ->whereIn('id', $ingredientIds)
            ->pluck('id')
            ->toArray();

        // Simpan ulang
        foreach ($validIds as $menuHasIngredientId) {
            CartIngredients::create([
                'cart_id' => $cartItem->id,
                'menu_has_ingredient_id' => $menuHasIngredientId,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Ingredients updated.');
    }

}
