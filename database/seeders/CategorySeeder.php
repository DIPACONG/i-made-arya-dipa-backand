<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Sesuai Bab 3.4.3 Modul dengan kategori disesuaikan untuk Toko Foto Jepret.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('categories')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('categories')->insert([
            ['category_id' => 1, 'category' => 'Pasar', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 2, 'category' => 'Pelabuhan', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 3, 'category' => 'Jalanan', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 4, 'category' => 'Budaya', 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 5, 'category' => 'Alam', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
