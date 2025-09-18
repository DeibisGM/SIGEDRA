<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EstudianteController extends Controller
{
    public function index(): View
    {
        return view('estudiantes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('estudiantes.create');
    }
}
