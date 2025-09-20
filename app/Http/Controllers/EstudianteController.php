<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Estudiante; // Import the Estudiante model
use App\Models\Grado; // Import the Grado model
use App\Models\AnioAcademico; // Import the AnioAcademico model

class EstudianteController extends Controller
{
    public function index(Request $request): View
    {
        $query = Estudiante::query();

        // Apply filters if present in the request
        if ($request->has('grado_id') && $request->grado_id != '') {
            $query->whereHas('asignacionesGrado', function ($q) use ($request) {
                $q->where('grado_id', $request->grado_id);
            });
        }
        // Removed anio_academico_id filter from whereHas due to unknown column

        $estudiantes = $query->get(); // Fetch filtered students

        $grados = Grado::all(); // Fetch all grades for the dropdown
        $aniosAcademicos = AnioAcademico::all(); // Fetch all academic years for the dropdown

        return view('estudiantes.index', compact('estudiantes', 'grados', 'aniosAcademicos'));
    }

    public function create(): View
    {
        return view('estudiantes.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return View
     */
    public function show(string $id): View
    {
        $student = Estudiante::findOrFail($id); // Fetch a specific student

        // Keep hardcoded data for courses and history for now
        $current_courses = [
            ['materia' => 'Matemáticas', 'profesor' => 'Ana Rojas', 'periodo_1' => 85, 'periodo_2' => 90, 'promedio' => 87.5, 'estado' => 'Aprobado'],
            ['materia' => 'Ciencias', 'profesor' => 'Carlos Perez', 'periodo_1' => 78, 'periodo_2' => 82, 'promedio' => 80, 'estado' => 'Aprobado'],
            ['materia' => 'Español', 'profesor' => 'Lucía Jimenez', 'periodo_1' => 92, 'periodo_2' => 88, 'promedio' => 90, 'estado' => 'Aprobado'],
            ['materia' => 'Estudios Sociales', 'profesor' => 'Pedro Solano', 'periodo_1' => 65, 'periodo_2' => 72, 'promedio' => 68.5, 'estado' => 'Reprobado'],
        ];

        $academic_history = [
            ['año' => '2023', 'grado' => 'Tercer Grado', 'promedio_final' => 88, 'estado' => 'Aprobado'],
            ['año' => '2022', 'grado' => 'Segundo Grado', 'promedio_final' => 91, 'estado' => 'Aprobado'],
            ['año' => '2021', 'grado' => 'Primer Grado', 'promedio_final' => 95, 'estado' => 'Aprobado'],
        ];


        return view('estudiantes.show', [
            'student' => $student,
            'current_courses' => $current_courses,
            'academic_history' => $academic_history,
        ]);
    }
}
