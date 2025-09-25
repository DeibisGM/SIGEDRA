<?php

namespace App\Http\Controllers;

use App\Models\Maestro;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaestroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $maestros = Maestro::with('user')->latest()->get();
        return view('maestros.index', compact('maestros'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Maestro $maestro): View
    {
        $maestro->load('user');
        return view('maestros.show', compact('maestro'));
    }
}
