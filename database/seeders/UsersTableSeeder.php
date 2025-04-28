<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.fr',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN
        ]);

        User::create([
            'name' => 'Client',
            'email' => 'client@client.fr',
            'password' => Hash::make('password'),
            'role' => User::ROLE_CLIENT,
            'client_id' => 1
        ]);
    }
}
