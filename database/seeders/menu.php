<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class menu extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menus')->insert([
            [
                'name' => 'Sunstar Fresh Melon Juice',
                'description' => 'Melon juice segar dan menyehatkan.',
                'nutrition_fact' => 'Vitamin C tinggi, tanpa pemanis buatan',
                'price' => 18000,
                'stock' => 50,
                'categories_id' => 2, // "Minuman", sesuaikan dengan ID dari seeder categories
            ],
            [
                'name' => 'Tropical Banana Smoothie',
                'description' => 'Smoothie pisang tropis yang creamy dan lezat.',
                'nutrition_fact' => 'Mengandung serat dan kalium',
                'price' => 20000,
                'stock' => 40,
                'categories_id' => 2, // juga kategori "Minuman"
            ],
        ]);
    }
}
