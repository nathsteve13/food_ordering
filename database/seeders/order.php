<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\OrderStatus;
use App\Models\DetailTransaction;
use Illuminate\Support\Str;

class order extends Seeder
{
    public function run(): void
    {
        $invoiceNumber = 'INV-' . strtoupper(Str::random(8));

        // Tambahkan transaksi
        $transaction = Transaction::create([
            'invoice_number' => $invoiceNumber,
            'subtotal' => 50000,
            'discount' => 5000,
            'total' => 45000,
            'order_type' => 'dinein',
            'payment_type' => 'qris',
            'users_id' => 1,
        ]);

        // Tambahkan status transaksi
        OrderStatus::create([
            'transactions_invoice_number' => $invoiceNumber,
            'status_type' => 'pending', // sesuaikan dengan isi tabel statuses
        ]);

        // Optional: tambah detail transaksi (kalau kamu punya data menu_id)
        // DetailTransaction::create([
        //     'transactions_invoice_number' => $invoiceNumber,
        //     'menu_id' => 1, // pastikan id menu 1 ada
        //     'quantity' => 2,
        //     'price' => 25000,
        //     'subtotal' => 50000
        // ]);
    }
}
