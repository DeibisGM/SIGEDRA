<?php

namespace App\Http\Controllers;

use App\Models\Maestro;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaestroController extends Controller
{
    /**
     * Muestra una lista de todos los maestros.
     */
    public function index(): View
    {
        $maestros = Maestro::with('user')->latest()->get();
        return view('maestros.index', compact('maestros'));
    }

    /**
     * Muestra los detalles de un maestro específico usando Route-Model Binding.
     */
    public function show(Maestro $maestro): View
    {
        $maestro->load('user'); // Asegura que la relación con el usuario esté cargada
        return view('maestros.show', compact('maestro'));
    }
}
