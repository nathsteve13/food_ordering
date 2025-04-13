<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user')->get();
        return view('orders.index', compact('transactions'));
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|unique:transactions,invoice_number',
            'subtotal' => 'required|numeric',
            'discount' => 'required|numeric',
            'total' => 'required|numeric',
            'order_type' => 'required|in:dinein,takeaway',
            'payment_type' => 'required|in:qris,credit,debit,e-wallet',
            'users_id' => 'required|exists:users,id',
        ]);

        DB::beginTransaction();
        try {
            Transaction::create($validated);
            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Transaction created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('orders.index')->with('error', 'Failed to create transaction: ' . $e->getMessage());
        }
    }

    public function show($invoice_number)
    {
        $order = Transaction::with('user')->findOrFail($invoice_number);
        return view('orders.show', compact('order'));
    }

    public function edit($invoice_number)
    {
        $order = Transaction::findOrFail($invoice_number);
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, $invoice_number)
    {
        $validated = $request->validate([
            'subtotal' => 'required|numeric',
            'discount' => 'required|numeric',
            'total' => 'required|numeric',
            'order_type' => 'required|in:dinein,takeaway',
            'payment_type' => 'required|in:qris,credit,debit,e-wallet',
            'users_id' => 'required|exists:users,id',
        ]);

        $order = Transaction::findOrFail($invoice_number);

        DB::beginTransaction();
        try {
            $order->update($validated);
            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Transaction updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('orders.index')->with('error', 'Failed to update transaction: ' . $e->getMessage());
        }
    }

    public function destroy($invoice_number)
    {
        $order = Transaction::findOrFail($invoice_number);

        DB::beginTransaction();
        try {
            $order->delete();
            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Transaction deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('orders.index')->with('error', 'Failed to delete transaction: ' . $e->getMessage());
        }
    }
}
