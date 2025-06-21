<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\OrderStatus;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\DetailTransaction;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['orderStatus', 'user'])->get();
        $customers = User::all();
        $menus = Menu::all();
        $orderTypes = ['dinein', 'takeaway'];
        $paymentTypes = ['qris', 'credit', 'debit', 'e-wallet'];

        return view('admin.order.index', compact(
            'transactions',
            'customers',
            'menus',
            'orderTypes',
            'paymentTypes'
        ));
    }


    public function detail($invoice_number)
    {
        // Ambil detail berdasarkan invoice + menu
        $details = DetailTransaction::with('menu')
            ->where('transactions_invoice_number', $invoice_number)
            ->get();

        // Ambil histori status
        $transactions = DB::table('order_status')
            ->where('transactions_invoice_number', $invoice_number)
            ->select('status_type', 'created_at')
            ->orderBy('created_at', 'asc')
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
        $v = $request->validate([
            'invoice_number' => 'required|unique:transactions,invoice_number',
            'subtotal' => 'required|numeric',
            'discount' => 'required|numeric',
            'total' => 'required|numeric',
            'order_type' => 'required|in:dinein,takeaway',
            'payment_type' => 'required|in:qris,credit,debit,e-wallet',
            'users_id' => 'required|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.menus_id' => 'required|exists:menus,id',
            'items.*.portion' => 'required|string|max:50',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.total' => 'required|numeric',
            'items.*.notes' => 'nullable|string|max:255',
        ]);


        DB::beginTransaction();
        try {
            // 1) Header transaksi
            $tx = Transaction::create([
                'invoice_number' => $v['invoice_number'],
                'subtotal' => $v['subtotal'],
                'discount' => $v['discount'],
                'total' => $v['total'],
                'order_type' => $v['order_type'],
                'payment_type' => $v['payment_type'],
                'users_id' => $v['users_id'],
            ]);

            // 2) Detail transaksi
            foreach ($v['items'] as $it) {
                DetailTransaction::create([
                    'transactions_invoice_number' => $tx->invoice_number,
                    'menus_id' => $it['menus_id'],
                    'portion' => $it['portion'],
                    'quantity' => $it['quantity'],
                    'total' => $it['total'],
                    'notes' => $it['notes'] ?? null,
                ]);
            }

            // 3) Initial status “pending”
            OrderStatus::create([
                'transactions_invoice_number' => $tx->invoice_number,
                'status_type' => 'pending',
            ]);

            DB::commit();
            return redirect()->route('admin.order.index')
                ->with('success', 'Transaction created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->route('admin.order.index')
                ->with('error', 'Failed to create transaction: ' . $e->getMessage());
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
    public function trashed()
    {
        $orders = Transaction::onlyTrashed()->with('user')->get();

        return view('admin.order.trashed', compact('orders'));
    }
    public function restore($invoice_number)
    {
        try {
            $order = Transaction::onlyTrashed()->findOrFail($invoice_number);
            $order->restore();

            return redirect()->route('admin.order.trashed')->with('success', 'Order restored successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.order.trashed')
                ->with('error', 'Failed to restore order: ' . $e->getMessage());
        }
    }
}
