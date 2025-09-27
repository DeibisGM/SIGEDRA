<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EstudianteController extends Controller
{
    public function index(): View
    {
        return view('estudiantes.index');
    }

    public function create(): View
    {
        return view('estudiantes.create');
    }

    public function show(Estudiante $estudiante): View
    {
        $estudiante->load(['grados.nivelAcademico', 'grados.anioAcademico']);

        // Datos de ejemplo para mantener la funcionalidad visual hasta que se implemente la lógica
        $current_courses = [];
        $academic_history = [];

        return view('estudiantes.show', [
            'student' => $estudiante,
            'current_courses' => $current_courses,
            'academic_history' => $academic_history,
        ]);
    }
}
