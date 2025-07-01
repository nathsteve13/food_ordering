<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\OrderType;
use App\Models\PaymentType;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\CartIngredients;
use App\Models\DetailTransaction;
use App\Models\MenusHasIngredient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailTransactionExclude;

class CartController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $cartItems = Cart::with(['menu.images', 'ingredients.ingredient'])
            ->where('users_id', $userId)
            ->get();

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->menus_price * $item->quantity ?? 0;
        }

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
        $cartItems = Cart::with(['menu.images', 'ingredients.ingredient'])
            ->where('users_id', $userId)
            ->get();
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
            'order_type' => 'required',
            'payment_type' => 'required',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'nullable',
            'items.*.portion' => 'required|string|max:50',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            $transaction = Transaction::create([
                'invoice_number' => Transaction::generateInvoiceNumber(),
                'subtotal' => $request->total,
                'discount' => 0,
                'total' => $request->total,
                'order_type' => $request->order_type,
                'payment_type' => $request->payment_type,
                'users_id' => $userId,
            ]);


            foreach ($request->items as $item) {
                $detailTransaction = DetailTransaction::create([
                    'transactions_invoice_number' => $transaction->invoice_number,
                    'menus_id' => $item['menu_id'],
                    'portion' => $item['portion'],
                    'quantity' => $item['quantity'],
                    'total' => $item['price'] * $item['quantity'],
                ]);

                $menuIngredients = MenusHasIngredient::with('ingredient')
                    ->where('menus_id', $item['menu_id'])
                    ->get()
                    ->toArray();

                foreach ($item['ingredients'] ?? [] as $ingredientRequest) {

                    foreach ($menuIngredients as $menuIngredient) {
                        if (!in_array($menuIngredient['ingredient']['name'], (array) $ingredientRequest)) {
                            DetailTransactionExclude::create([
                                'detail_transaction_id' => $detailTransaction->id,
                                'ingredients_id' => $menuIngredient['ingredients_id'],
                            ]);

                        }
                    }
                }
            }

            Cart::where('users_id', $userId)->delete();
            DB::commit();

            return redirect()->route('cart.index')->with('success', 'Checkout successful!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Checkout failed: ' . $e->getMessage());
        }

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
