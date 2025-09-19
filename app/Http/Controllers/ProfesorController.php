<?php

namespace App\Http\Controllers;

use App\Models\Maestro;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfesorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $profesores = Maestro::with('user')->latest()->get();
        return view('profesores.index', compact('profesores'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Maestro $profesore): View
    {
        $profesore->load('user');
        return view('profesores.show', compact('profesore'));
    }
}
