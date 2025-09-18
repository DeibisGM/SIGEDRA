<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
