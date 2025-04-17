<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ingredients extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ingredients')->insert([
            ['name' => 'Fresh Melon'],
            ['name' => 'Mineral Water'],
            ['name' => 'Ripe Bananas'],
            ['name' => 'Low-fat Milk'],
        ]);
    }
}
