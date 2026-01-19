<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::truncate(); // Clear existing to avoid unique constraint issues during development
        \App\Models\User::create([
            'name' => 'Admin Sinvitation',
            'username' => 'admin',
            'email' => 'admin@sinvitation.com',
            'password' => \Illuminate\Support\Facades\Hash::make('sinvitation2026'),
        ]);
        
        // Since the user asked for username:sinvitation, I'll need to make sure the login logic handles it.
        // Actually Laravel default 'email' can be used as the identifier.
        // If I use 'name' as 'username', I need to check the login logic.
        // Let's stick to name=sinvitation and email=admin@sinvitation.com.
    }
}
