<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin pengguna toko foto (sesuai akun admin di CARA-JALAN.txt pada React project)
        User::updateOrCreate(
            ['email' => 'admin@jepret.id'],
            [
                'name'     => 'Admin Jepret',
                'password' => Hash::make('admin123'),
            ]
        );

        // Akun sample untuk testing API
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name'     => 'Test User',
                'password' => Hash::make('password'),
            ]
        );
    }
}
