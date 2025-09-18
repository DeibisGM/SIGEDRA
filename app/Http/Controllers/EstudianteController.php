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
        // --- MÉTODO ACTUALIZADO ---

        // CAMBIO: Se ajustan los datos para reflejar grados de primaria y se elimina la sección.
        $student = [
            'cedula' => '1-1234-5678',
            'nombre_completo' => 'John Deibys Gutierrez Morales',
            'fecha_nacimiento' => '2015-03-15', // Fecha ajustada para una edad de primaria
            'edad' => 9,
            'genero' => 'Masculino',
            'nacionalidad' => 'Costarricense',
            'direccion' => 'San José, Desamparados, Calle Fallas',
            'grado_actual' => 'Cuarto Grado',
            'status' => 'Activo',
            'avatar_initials' => 'JG',
            'encargado' => [
                'nombre' => 'Maria Morales (Madre)',
                'telefono' => '8888-8888',
                'email' => 'maria.morales@email.com',
            ],
            'adecuacion' => [
                'requiere' => true,
                'tipo' => 'No Significativa',
                'detalles' => 'Requiere tiempo adicional en evaluaciones y sentarse en las primeras filas del aula debido a déficit de atención.',
            ],
        ];

        // CAMBIO: Datos de cursos ajustados a un contexto de primaria.
        $current_courses = [
            ['materia' => 'Matemáticas', 'profesor' => 'Ana Rojas', 'periodo_1' => 85, 'periodo_2' => 90, 'promedio' => 87.5, 'estado' => 'Aprobado'],
            ['materia' => 'Ciencias', 'profesor' => 'Carlos Perez', 'periodo_1' => 78, 'periodo_2' => 82, 'promedio' => 80, 'estado' => 'Aprobado'],
            ['materia' => 'Español', 'profesor' => 'Lucía Jimenez', 'periodo_1' => 92, 'periodo_2' => 88, 'promedio' => 90, 'estado' => 'Aprobado'],
            ['materia' => 'Estudios Sociales', 'profesor' => 'Pedro Solano', 'periodo_1' => 65, 'periodo_2' => 72, 'promedio' => 68.5, 'estado' => 'Reprobado'],
        ];

        // CAMBIO: Historial ajustado a grados de primaria.
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
