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
        $adminPassword = env('ADMIN_PASSWORD');

        if (! $adminPassword && app()->environment('production')) {
            $this->command?->warn('ADMIN_PASSWORD is not set; skipping admin user.');

            return;
        }

        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'abfuadi93@gmail.com')],
            [
                'name' => env('ADMIN_NAME', 'Admin Edulaw'),
                'password' => Hash::make($adminPassword ?: 'password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
