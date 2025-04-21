<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'username' => 'admin',
            'password' => Hash::make('password'),
            'email' => 'admin@example.com',
            'role' => 'admin'
        ]);

        User::create([
            'username' => 'petugas',
            'password' => Hash::make('password'),
            'email' => 'kasir1@example.com',
            'role' => 'petugas'
        ]);
    }
}