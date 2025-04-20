<?php

// database/seeders/DetailTransactionSeeder.php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use App\Models\DetailTransaction;
use Illuminate\Support\Facades\DB;

class DetailTransactionSeeder extends Seeder
{
    public function run(): void
    {
        $menuIds = DB::table('menus')->pluck('id')->toArray();
        $transactions = DB::table('transactions')->get();

        foreach ($transactions as $transaction) {
            for ($i = 0; $i < 5; $i++) {
                $menuId = $menuIds[array_rand($menuIds)];
                $qty = rand(1, 3);
                $portion = rand(1, 2); // misalnya 1 = regular, 2 = large
                $pricePerItem = rand(10000, 30000);
                $total = $qty * $pricePerItem;
                $notes = ['tanpa sambal', 'extra keju', 'garing', '', ''][rand(0, 4)];

                DB::table('detail_transactions')->insert([
                    'transactions_invoice_number' => $transaction->invoice_number,
                    'menus_id' => $menuId,
                    'portion' => $portion,
                    'quantity' => $qty,
                    'total' => $total,
                    'notes' => $notes,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

}
