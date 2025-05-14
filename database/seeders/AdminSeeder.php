<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $user = User::where('email', 'admin@example.com')->first();
        if ($user) {
            $user->update(['role_id' => $adminRole->id]);
        } else {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id
            ]);
        }
    }
}
