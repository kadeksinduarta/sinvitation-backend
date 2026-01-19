<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'sinvitation'],
            [
                'name' => 'Admin Sinvitation',
                'email' => 'admin@sinvitation.com', // Optional email
                'password' => Hash::make('sinvitation2026'),
            ]
        );
    }
}
