<?php

// database/seeders/TransactionSeeder.php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = DB::table('users')->pluck('id')->toArray();

        for ($i = 0; $i < 5; $i++) {
            DB::table('transactions')->insert([
                'invoice_number' => 'INV' . strtoupper(Str::random(8)),
                'subtotal' => 150000,
                'discount' => 10000,
                'total' => 140000,
                'order_type' => ['dinein', 'takeaway'][rand(0,1)],
                'payment_type' => ['qris', 'credit', 'debit', 'e-wallet'][rand(0,3)],
                'users_id' => $userIds[array_rand($userIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
