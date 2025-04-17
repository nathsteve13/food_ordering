<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class categories extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Makanan Berat',
                'image_path' => 'images/categories/makanan_berat.jpg',
            ],
            [
                'name' => 'Minuman',
                'image_path' => 'images/categories/minuman.jpg',
            ],
            [
                'name' => 'Cemilan',
                'image_path' => 'images/categories/cemilan.jpg',
            ],
            [
                'name' => 'Makanan Penutup',
                'image_path' => 'images/categories/penutup.jpg',
            ],
        ]);
    }
}
