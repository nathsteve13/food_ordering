<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class menus_has_ingredients extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menus_has_ingredients')->insert([
            [
                'menus_id' => 1,
                'ingredients_id' => 1, // contoh: melon
            ],
            [
                'menus_id' => 1,
                'ingredients_id' => 2, // contoh: gula
            ],
            [
                'menus_id' => 2,
                'ingredients_id' => 3, // contoh: pisang
            ],
            [
                'menus_id' => 2,
                'ingredients_id' => 4, // contoh: susu
            ],
        ]);
    }
}
