<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Estudiante;

class EstudianteController extends Controller
{
    /**
     * Muestra la página de gestión de estudiantes.
     * La vista simplemente cargará el componente Livewire, que se encargará del resto.
     */
    public function index(): View
    {
        return view('estudiantes.index');
    }

    /**
     * Muestra el formulario para crear un nuevo estudiante.
     */
    public function create(): View
    {
        return view('estudiantes.create');
    }

    /**
     * Muestra el perfil detallado de un estudiante específico.
     */
    public function show(string $id): View
    {
        // Usamos findOrFail para que Laravel automáticamente muestre un error 404 si el ID no existe.
        // Usamos with() para cargar las relaciones de forma eficiente y evitar consultas extra.
        $student = Estudiante::with(['grados.nivelAcademico', 'grados.anioAcademico'])->findOrFail($id);

        // Manteniendo los datos de ejemplo para las otras secciones del perfil como se solicitó.
        $current_courses = [
            ['materia' => 'Matemáticas', 'maestro' => 'Ana Rojas', 'periodo_1' => 85, 'periodo_2' => 90, 'promedio' => 87.5, 'estado' => 'Aprobado'],
            ['materia' => 'Ciencias', 'maestro' => 'Carlos Perez', 'periodo_1' => 78, 'periodo_2' => 82, 'promedio' => 80, 'estado' => 'Aprobado'],
            ['materia' => 'Español', 'maestro' => 'Lucía Jimenez', 'periodo_1' => 92, 'periodo_2' => 88, 'promedio' => 90, 'estado' => 'Aprobado'],
            ['materia' => 'Estudios Sociales', 'maestro' => 'Pedro Solano', 'periodo_1' => 65, 'periodo_2' => 72, 'promedio' => 68.5, 'estado' => 'Reprobado'],
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
