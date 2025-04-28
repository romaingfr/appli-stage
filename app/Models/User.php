<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function hasPermission($permission)
    {
        if ($this->isAdmin()) {
            return true;
        }

        // Permissions par défaut pour tous les utilisateurs authentifiés
        $defaultPermissions = [
            'view-clients',
            'create-clients',
            'edit-clients',
            'delete-clients',
            'view-sites',
            'create-sites',
            'edit-sites',
            'delete-sites',
        ];

        return in_array($permission, $defaultPermissions);
    }
}
