<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\DetailTransaction;
use App\Models\DetailTransactionExclude;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $iduser = Auth::user()->id;
        $cart = Cart::where('user_id', $iduser)->get();
        $cartDetails = Cart::with(['menu.images', 'ingredients.ingredient'])
            ->where('users_id', $iduser)
            ->get();

        return view('checkout.index', compact('cart', 'cartDetails'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $request->validate([
            'subtotal' => 'required|numeric',
            'discount' => 'required|numeric',
            'total' => 'required|numeric',
            'order_type' => 'required|in:dinein,takeaway',
            'payment_type' => 'required|in:qris,credit,debit,e-wallet',
            'cart_items' => 'required|array|min:1',
            'cart_items.*.menu_id' => 'required|exists:menus,id',
            'cart_items.*.portion' => 'required|string|max:50',
            'cart_items.*.quantity' => 'required|integer|min:1',
            'cart_items.*.total' => 'required|numeric',
            'cart_items.*.notes' => 'nullable|string|max:255',
            'cart_items.*.excludes' => 'nullable|array',
            'cart_items.*.excludes.*.ingredient_id' => 'required|exists:ingredients,id',
        ]);

        try {
            $iduser = Auth::user()->id;
            $transaction = Transaction::create([
                'invoice_number' => Transaction::generateInvoiceNumber(),
                'subtotal' => $request->subtotal,
                'discount' => $request->discount,
                'total' => $request->total,
                'order_type' => $request->order_type,
                'payment_type' => $request->payment_type,
                'users_id' => $iduser,
            ]);

            foreach ($request->cart_items as $item) {
                DetailTransaction::create([
                    'transactions_invoice_number' => $transaction->invoice_number,
                    'menus_id' => $item['menu_id'],
                    'portion' => $item['portion'],
                    'quantity' => $item['quantity'],
                    'total' => $item['total'],
                    'notes' => $item['notes'] ?? null,
                ]);

                if (!empty($item['excludes'])) {
                    foreach ($item['excludes'] as $exclude) {
                        DetailTransactionExclude::create([
                            'transactions_invoice_number' => $transaction->invoice_number,
                            'menus_id' => $item['menu_id'],
                            'ingredients_id' => $exclude['ingredient_id'],
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('checkout.success')->with('success', 'Transaction completed successfully!');
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->route('checkout.index')->with('error', 'Transaction failed: ' . $e->getMessage());
        }
    }
}
