<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PdfPreviewController extends Controller
{
    /**
     * Muestra la vista de previsualización para PDF.
     */
    public function index(): View
    {
        // Usaremos datos quemados para simular un reporte
        $student = [
            'nombre_completo' => 'John Deibys Gutierrez Morales',
            'cedula' => '1-1234-5678',
            'grado_actual' => 'Cuarto Grado',
        ];

        $courses = [
            ['materia' => 'Matemáticas', 'profesor' => 'Ana Rojas', 'promedio' => 87.5, 'estado' => 'Aprobado'],
            ['materia' => 'Ciencias', 'profesor' => 'Carlos Perez', 'promedio' => 80, 'estado' => 'Aprobado'],
            ['materia' => 'Español', 'profesor' => 'Lucía Jimenez', 'promedio' => 90, 'estado' => 'Aprobado'],
            ['materia' => 'Estudios Sociales', 'profesor' => 'Pedro Solano', 'promedio' => 68.5, 'estado' => 'Reprobado'],
        ];

        return view('pdf_preview.index', [
            'student' => $student,
            'courses' => $courses,
        ]);
    }
}
