<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class LoginTestController extends Controller
{
    /**
     * Muestra la vista de prueba del login.
     */
    public function index(): View
    {
        return view('login_test.index');
    }

    /**
     * Fix the password for the first user.
     */
    public function fixPassword()
    {
        $user = User::find(1);
        if ($user) {
            $user->contrasena = Hash::make('password');
            $user->save();
            return 'Password for user ' . $user->cedula . ' has been reset to "password". You can now try logging in.';
        }
        return 'User with ID 1 not found.';
    }
}
