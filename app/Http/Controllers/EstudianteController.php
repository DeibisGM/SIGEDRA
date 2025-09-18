<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use Illuminate\Http\RedirectResponse;
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'cedula' => 'required|unique:estudiante,cedula|max:30',
            'primer_nombre' => 'required|string|max:50',
            'segundo_nombre' => 'nullable|string|max:50',
            'primer_apellido' => 'required|string|max:50',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'nullable|string|max:1',
            'nacionalidad' => 'nullable|string|max:50',
        ]);

        Estudiante::create($validated);

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante creado exitosamente.');
    }
}
