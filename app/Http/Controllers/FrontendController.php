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
        $recentMenus = Menu::where('created_at', '>=', Carbon::now()->subWeek())->get();

        $menus = Menu::with(['images', 'category'])
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->get();

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
        $menu = Menu::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $menu->name,
                'quantity' => 1,
                'price' => $menu->price,
                'image' => $menu->images->first()->image_path ?? 'images/default.jpg'
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Item added to cart!');
    }


    public function viewCart()
    {
        $user = Auth::id() ? User::find(Auth::id()) : null;

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $cart = Cart::where('users_id', $user->id)
            ->with(['menu', 'ingredients'])
            ->get()
            ->toArray();

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['menus_price'] * $item['quantity'];
        }

        dd($cart);

        return view('cart.index', compact('cart', 'total'));
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item removed from cart!');
    }


    public function updateQuantity(Request $request)
    {
        $id = $request->input('id');
        $quantity = $request->input('quantity');

        // Ambil cart dari session
        $cart = session()->get('cart', []);

        // Kalau item-nya ada, update quantity-nya
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;

            // Simpan kembali ke session
            session()->put('cart', $cart);

            // Hitung subtotal dan total baru
            $subtotal = $cart[$id]['price'] * $quantity;
            $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

            return response()->json([
                'success' => true,
                'subtotal' => $subtotal,
                'total' => $total
            ]);
        }

        // Kalau ID tidak ditemukan
        return response()->json(['success' => false], 404);
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
}
