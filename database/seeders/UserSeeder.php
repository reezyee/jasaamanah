<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin'),
                'role' => 'admin',
                'division' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Worker User',
                'email' => 'worker@example.com',
                'password' => Hash::make('worker'),
                'role' => 'worker',
                'division' => 'Design',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Client User',
                'email' => 'client@example.com',
                'password' => Hash::make('client'),
                'role' => 'client',
                'division' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
