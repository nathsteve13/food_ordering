<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\CartIngredients;
use App\Models\Menu;
use App\Models\User;
use App\Models\Category;
use App\Models\Frontend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recentMenus = Menu::with('images')->where('created_at', '>=', Carbon::now()->subWeek())->get();

        $menus = Menu::with(['images', 'category'])->get();

        $bestSellingMenus = Menu::with('images')
            ->join('detail_transactions', 'menus.id', '=', 'detail_transactions.menus_id')
            ->select('menus.id', 'menus.name', 'menus.description', 'menus.price', 'menus.stock', 'menus.categories_id') // semua kolom yang dibutuhkan
            ->selectRaw('SUM(detail_transactions.quantity) as total_sold')
            ->groupBy('menus.id', 'menus.name', 'menus.description', 'menus.price', 'menus.stock', 'menus.categories_id')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        $categories = Category::all();

        return view('home', compact('recentMenus', 'menus', 'bestSellingMenus', 'categories'));
    }
    public function addToCart(Request $request, $id)
    {
        $menu = Menu::with('images')->findOrFail($id);
        $userId = auth()->id();

        // Cek apakah cart untuk user dan menu ini sudah ada
        $cart = Cart::firstOrNew([
            'users_id' => $userId,
            'menus_id' => $menu->id,
        ]);

        $cart->menus_price = $menu->price;
        $cart->quantity = $cart->exists ? $cart->quantity + 1 : 1;
        $cart->save();

        // Simpan ingredients (ID-nya berasal dari tabel menus_has_ingredients)
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




    public function viewCart()
    {
        $userId = auth()->id();
        $cartItems = Cart::with(['menu.images', 'ingredients.ingredient'])
            ->where('users_id', $userId)
            ->get();

        $total = $cartItems->sum(fn($item) => $item->menus_price * $item->quantity);

        return view('cart.index', compact('cartItems', 'total'));
    }


    public function removeFromCart($id)
    {
        $cart = Cart::findOrFail($id);

        if ($cart->users_id !== auth()->id()) {
            abort(403);
        }

        $cart->ingredients()->detach();
        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed.');
    }



    public function updateQuantity(Request $request)
    {
        $cartId = $request->input('id');
        $quantity = $request->input('quantity');

        // Cari cart berdasarkan ID
        $cart = Cart::find($cartId);

        // Jika cart tidak ditemukan
        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Cart not found'], 404);
        }

        // Jangan izinkan jumlah < 1
        if ($quantity < 1) {
            return response()->json(['success' => false, 'message' => 'Quantity must be at least 1'], 422);
        }

        // Update quantity
        $cart->quantity = $quantity;
        $cart->save();

        // Hitung subtotal dan total semua cart milik user
        $subtotal = $cart->menus_price * $cart->quantity;

        $userTotal = Cart::where('users_id', $cart->users_id)->get()->sum(function ($item) {
            return $item->menus_price * $item->quantity;
        });

        return response()->json([
            'success' => true,
            'subtotal' => $subtotal,
            'total' => $userTotal
        ]);
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $menu = Menu::with(['images', 'category', 'ingredients'])->findOrFail($id);

        return view('menus.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Frontend $frontend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Frontend $frontend)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Frontend $frontend)
    {
        //
    }

    public function showByCategory($id)
    {
        $category = Category::findOrFail($id);
        $menus = Menu::where('categories_id', $id)->get(); // sesuaikan nama kolom foreign key-nya

        return view('menus.byCategory', compact('category', 'menus'));
    }
}
