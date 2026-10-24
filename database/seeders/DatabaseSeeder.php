<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Sesuai Bab 3.4.3 Modul Praktikum RESTful API.
     */
    public function run(): void
    {
        // Nonaktifkan pemeriksaan foreign key sementara agar seeder dapat membersihkan/mengisi ulang data tanpa error 1701
        Schema::disableForeignKeyConstraints();

        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            PhotoSeeder::class,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
