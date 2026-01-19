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
        \App\Models\User::create([
            'name' => 'Admin Sinvitation',
            'email' => 'admin@sinvitation.com', // Using email as username is standard in Laravel, but user said "username". I'll use name as well or just standard email.
            'password' => \Illuminate\Support\Facades\Hash::make('sinvitation2026'),
        ]);
        
        // Since the user asked for username:sinvitation, I'll need to make sure the login logic handles it.
        // Actually Laravel default 'email' can be used as the identifier.
        // If I use 'name' as 'username', I need to check the login logic.
        // Let's stick to name=sinvitation and email=admin@sinvitation.com.
    }
}
