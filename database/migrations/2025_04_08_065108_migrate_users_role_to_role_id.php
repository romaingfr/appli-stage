<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\User;
use App\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $role = Role::where('name', $user->role)->first();
            if ($role) {
                $user->role_id = $role->id;
                $user->save();
            }
        }
    }

    public function down(): void
    {
        // Rien à faire ici
    }
};
