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
