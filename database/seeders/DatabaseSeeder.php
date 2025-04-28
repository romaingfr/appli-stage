<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Création des rôles
        $this->call(RoleSeeder::class);

        // Création de l'admin
        $this->call(AdminSeeder::class);

        // Création des clients
        $this->call(ClientSeeder::class);

        // Création d'un seul site principal
        $this->call(SitesTableSeeder::class);
        // Commentez ou supprimez cette ligne si vous ne voulez pas de site secondaire
        // $this->call(SecondarySitesTableSeeder::class);

        // Création utilisateur test
        $userRole = Role::where('name', 'user')->first();
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'User Test',
                'password' => Hash::make('password'),
                'role_id' => $userRole->id
            ]
        );
    }
}
