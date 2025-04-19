<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Menu;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Active Member
        $activeMembers = DB::table('transactions')
            ->join('users', 'transactions.users_id', '=', 'users.id')
            ->where('transactions.created_at', '>=', Carbon::now()->subDays(30))
            ->select('users.id', 'users.name', 'users.email')
            ->distinct()
            ->get();

        // 2. Top Member (FIXED - pakai invoice_number)
        $topMember = DB::table('transactions')
            ->join('users', 'transactions.users_id', '=', 'users.id')
            ->select('users.id', 'users.name', DB::raw('COUNT(transactions.invoice_number) as total_transactions'))
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_transactions')
            ->first();

        // 3. Menu Paling Banyak Dipesan
        $topMenu = DB::table('detail_transactions')
            ->join('menus', 'detail_transactions.menus_id', '=', 'menus.id')
            ->select('menus.name', DB::raw('SUM(detail_transactions.quantity) as total_quantity'))
            ->groupBy('menus.name')
            ->orderByDesc('total_quantity')
            ->first();

        return view('reports.index', compact('activeMembers', 'topMember', 'topMenu'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
