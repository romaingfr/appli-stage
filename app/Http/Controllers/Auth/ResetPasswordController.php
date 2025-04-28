<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Où rediriger les utilisateurs après la réinitialisation de leur mot de passe.
     *
     * @var string
     */
    protected $redirectTo = '/clients/search';

    /**
     * Crée une nouvelle instance du contrôleur.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
}
