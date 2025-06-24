<?php

namespace App\Http\Controllers;

use App\Models\Frontend;
use Illuminate\Http\Request;
use App\Models\Menu;
use Carbon\Carbon;

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

        return view('home', compact('recentMenus', 'menus', 'bestSellingMenus'));
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
    public function show(Frontend $frontend)
    {
        //
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
