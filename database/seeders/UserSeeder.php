<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama'     => 'Super Admin',
            'username' => 'superadmin',
            'password' => Hash::make('password'),
            'role'     => 'super_admin',
        ]);

        User::create([
            'nama'     => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);
    }
}
