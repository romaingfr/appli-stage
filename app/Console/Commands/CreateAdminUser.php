<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'create:admin';
    protected $description = 'Crée un utilisateur administrateur';

    public function handle()
    {
        $name = $this->ask('Nom de l\'administrateur ?');
        $email = $this->ask('Email ?');
        $password = $this->secret('Mot de passe ?');

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => User::ROLE_ADMIN
        ]);

        $this->info('Administrateur créé avec succès !');
    }
}
