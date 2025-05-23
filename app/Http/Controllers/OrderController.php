<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaction;
use App\Models\Transaction;
use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['orderStatus', 'user'])->get();
        return view('admin.order.index', compact('transactions'));
    }


    public function detail($invoice_number)
    {
        $details = DetailTransaction::with(['transaction', 'menu'])->where('transactions_invoice_number', $invoice_number)->get();
        $transactions = DB::table('transactions')
            ->join('order_status', 'transactions.invoice_number', '=', 'order_status.transactions_invoice_number')
            ->where('transactions.invoice_number', $invoice_number)
            ->select('order_status.status_type', 'order_status.created_at')
            ->get();

        return response()->json([
            'details' => $details,
            'transactions' => $transactions,
        ]);
    }


    public function create()
    {
        return view('admin.order.create');
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

            return redirect()->route('admin.order.index')->with('success', 'Transaction created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.order.index')->with('error', 'Failed to create transaction: ' . $e->getMessage());
        }
    }

    public function show($invoice_number)
    {
        $order = Transaction::with('user')->findOrFail($invoice_number);
        return view('admin.order.show', compact('order'));
    }

    public function edit($invoice_number)
    {
        $order = Transaction::with('orderStatus')->findOrFail($invoice_number);
        $statuses = ['pending', 'proccessed', 'ready'];
        $customers = User::all();
        return view('admin.order.edit', compact('order', 'statuses', 'customers'));
    }

    public function update(Request $request, $invoice_number)
    {
        $validated = $request->validate([
            'status_type' => 'required|in:pending,proccessed,ready',
        ]);

        $order = Transaction::with('orderStatus')->findOrFail($invoice_number);

        DB::beginTransaction();
        try {
            // Jika sudah ada status, update
            if ($order->orderStatus) {
                $order->orderStatus->update([
                    'status_type' => $validated['status_type'],
                ]);
            } else {
                // Jika belum ada status, buat baru
                $order->orderStatus()->create([
                    'transactions_invoice_number' => $invoice_number,
                    'status_type' => $validated['status_type'],
                ]);
            }

            DB::commit();
            return redirect()->route('admin.order.index')->with('success', 'Update Status Successfull.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.order.index')->with('error', 'Failed to Update Status: ' . $e->getMessage());
        }
    }

    public function destroy($invoice_number)
    {
        $order = Transaction::findOrFail($invoice_number);

        DB::beginTransaction();
        try {
            $order->delete();
            DB::commit();

            return redirect()->route('admin.order.index')->with('success', 'Transaction deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.order.index')->with('error', 'Failed to delete transaction: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $invoice_number)
    {
        $validated = $request->validate([
            'status_type' => 'required|in:pending,proccessed,ready',
        ]);

        $order = Transaction::with('orderStatus')->findOrFail($invoice_number);

        DB::beginTransaction();
        try {
            if ($order->orderStatus) {
                $order->orderStatus->update([
                    'status_type' => $validated['status_type'],
                ]);
            } else {
                $order->orderStatus()->create([
                    'transactions_invoice_number' => $invoice_number,
                    'status_type' => $validated['status_type'],
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to update status: ' . $e->getMessage()], 500);
        }
    }
}
