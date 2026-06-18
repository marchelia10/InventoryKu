<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin IT',
            'email' => 'admin@mail.com',
            'divisi' => 'IT',
            'no_telepon' => '081234567890',
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Karyawan',
            'email' => 'karyawan@mail.com',
            'divisi' => 'Finance',
            'no_telepon' => '081234567890',
            'role' => 'karyawan',
            'password' => Hash::make('password123'),
        ]);
    }
}
