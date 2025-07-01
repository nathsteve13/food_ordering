<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\OrderStatus;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\DetailTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function getLatestInvoiceNumber()
    {
        $today = now()->format('Ymd');
        $count = Transaction::whereDate('created_at', today())->count() + 1;
        $formatted = str_pad($count, 4, '0', STR_PAD_LEFT);
        $result = "INV-".$today."-".$formatted;
        return $result;
    }

    public function detail($invoice_number)
    {
        try {
            $details = DetailTransaction::with(['menu', 'excludedIngredients.ingredient'])
                ->where('transactions_invoice_number', $invoice_number)
                ->get();

            $transactions = DB::table('order_status')
                ->where('transactions_invoice_number', $invoice_number)
                ->select('status_type', 'created_at')
                ->orderBy('created_at', 'asc')
                ->get();

            return response()->json([
                'details' => $details,
                'transactions' => $transactions,
            ]);
        } catch (\Throwable $e) {
            Log::error('[DETAIL ERROR] ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    public function create()
    {
        return view('admin.order.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'discount' => preg_replace('/[^0-9.]/', '', $request->discount),
        ]);
        $v = $request->validate([
            'subtotal' => 'required|numeric',
            'discount' => 'required|string',
            'total' => 'required|numeric',
            'order_type' => 'required|in:dinein,takeaway',
            'payment_type' => 'required|in:qris,credit,debit,e-wallet',
            'users_id' => 'required|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.menus_id' => 'required|exists:menus,id',
            'items.*.portion' => 'required|string|max:50',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.subtotal' => 'required|numeric',
            'items.*.total' => 'required|numeric',
            'items.*.notes' => 'nullable|string|max:255',
        ]);
        
        $discountValue = 0;
        if (str_contains($v['discount'], '%')) {
            $percentage = floatval(str_replace('%', '', $v['discount']));
            $discountValue = $v['subtotal'] * ($percentage / 100);
        } else {
            $discountValue = $v['subtotal'] * (floatval($v['discount']) /100);
        }
        DB::beginTransaction();
        $invoice_number = $this->getLatestInvoiceNumber();
        
        try {
            $tx = Transaction::create([
                'invoice_number' => $invoice_number,
                'subtotal' => $v['subtotal'],
                'discount' => $discountValue,
                'total' => $v['subtotal'] - $discountValue,
                'order_type' => $v['order_type'],
                'payment_type' => $v['payment_type'],
                'users_id' => $v['users_id'],
            ]);
            
            foreach ($v['items'] as $it) {
                DetailTransaction::create([
                    'transactions_invoice_number' => $tx->invoice_number,
                    'menus_id' => $it['menus_id'],
                    'portion' => $it['portion'],
                    'quantity' => $it['quantity'],
                    'subtotal' => $it['subtotal'],
                    'total' => $it['total'],
                    'notes' => $it['notes'] ?? null,
                ]);
            }
            
            OrderStatus::create([
                'transactions_invoice_number' => $tx->invoice_number,
                'status_type' => 'pending',
            ]);

            DB::commit();
            return redirect()->route('admin.order.index')
                ->with('success', 'Order berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan order: ' . $e->getMessage());
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
            $currentStatus = $order->orderStatus->status_type ?? null;

            if (($currentStatus === 'proccessed' && $validated['status_type'] === 'pending') ||
                ($currentStatus === 'ready' && $validated['status_type'] === 'proccessed')) {
                throw new \Exception('Invalid status transition.');
            }

            if ($currentStatus === $validated['status_type']) {
                return response()->json(['message' => 'Status is already up-to-date']);
            }

            $order->orderStatus()->create([
                'transactions_invoice_number' => $invoice_number,
                'status_type' => $validated['status_type'],
            ]);

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

    public function checkoutForm()
    {
        $userId = auth()->id(); // ambil user login
        $cart = Cart::with('menu')->where('users_id', $userId)->get();

        $users = User::all();
        $orderTypes = ['dinein', 'takeaway'];
        $paymentTypes = ['qris', 'credit', 'debit', 'e-wallet'];

        $total = $cart->sum(function ($item) {
            return $item->menus_price * $item->quantity;
        });

        return view('cart.checkout', compact('cartItems', 'users', 'orderTypes', 'paymentTypes', 'total'));
    }


    public function processCheckout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Cart is empty!');
        }

        $request->validate([
            'users_id' => 'required|exists:users,id',
            'order_type' => 'required|in:dinein,takeaway',
            'payment_type' => 'required|in:qris,credit,debit,e-wallet',
        ]);

        DB::beginTransaction();
        try {
            $invoice_number = $this->getLatestInvoiceNumber();
            $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
            $discount = 0; // Bisa tambahkan logic diskon nanti

            $transaction = Transaction::create([
                'invoice_number' => $invoice_number,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $subtotal - $discount,
                'order_type' => $request->order_type,
                'payment_type' => $request->payment_type,
                'users_id' => $request->users_id,
            ]);

            foreach ($cart as $menuId => $item) {
                DetailTransaction::create([
                    'transactions_invoice_number' => $transaction->invoice_number,
                    'menus_id' => $menuId,
                    'portion' => 'Regular',
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                    'total' => $item['price'] * $item['quantity'],
                    'notes' => null,
                ]);
            }

            OrderStatus::create([
                'transactions_invoice_number' => $transaction->invoice_number,
                'status_type' => 'pending',
            ]);

            session()->forget('cart');

            DB::commit();
            return redirect()->route('admin.order.index')->with('success', 'Checkout berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Checkout gagal: ' . $e->getMessage());
        }
    }


}