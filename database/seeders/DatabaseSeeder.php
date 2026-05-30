<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Membuat User Admin Permanen
        User::updateOrCreate(
            ['email' => 'abfuadi93@gmail.com'], // Kunci pencarian
            [
                'name' => 'Admin Edulaw',
                'password' => Hash::make('Abfuadi!13'), // Ganti sesuai keinginan
                'email_verified_at' => now(),
            ]
        );

        // 2. Opsi: Membuat user tambahan untuk testing (Opsional)
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Jika Anda ingin membuat 10 user random sekaligus, aktifkan ini:
        // User::factory(10)->create();
    }
}