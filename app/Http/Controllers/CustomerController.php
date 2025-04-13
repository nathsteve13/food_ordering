<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::with('transactions')->get();

        return view('customers.index', compact('customers'));
    }
}
