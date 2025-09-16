<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@perpus.com'],
            [
                'name' => 'Admin Perpus',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );
    }
}

