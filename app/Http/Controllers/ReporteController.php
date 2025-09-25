<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReporteController extends Controller
{
    public function index(): View
    {
        // --- INICIO DE DATOS QUEMADOS PARA LA VISTA ---

        // 1. Métricas principales para las tarjetas (ajustadas a la imagen)
        $metrics = [
            'total_students' => 124,
            'average_attendance' => 92, // Porcentaje
            'approved_students' => 116,
            'at_risk_students' => 8,
        ];

        // 2. Datos para el gráfico de asistencia mensual (Formato para Chart.js)
        $attendanceData = [
            'labels' => ['Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul'],
            'datasets' => [
                [
                    'label' => 'Presente',
                    'data' => [95, 96, 91, 93, 89, 92],
                    'backgroundColor' => '#7AA352',
                ],
                [
                    'label' => 'Ausente',
                    'data' => [5, 4, 9, 7, 11, 8],
                    'backgroundColor' => '#D9534F',
                ],
            ],
        ];

        // 3. Datos para el gráfico de distribución de notas (Formato para Chart.js)
        $gradesData = [
            'labels' => ['Sobresaliente (90-100)', 'Notable (80-89)', 'Suficiente (70-79)', 'En Riesgo (<70)'],
            'datasets' => [
                [
                    'data' => [60, 35, 21, 8],
                    'backgroundColor' => ['#34A853', '#7AA352', '#F0AD4E', '#D9534F'],
                ],
            ],
        ];

        // 4. Lista de estudiantes con más ausencias
        $topAbsences = [
            ['nombre' => 'Carlos José González Mora', 'ausencias' => 12, 'grado' => 'Cuarto Grado'],
            ['nombre' => 'Luis Andrés Martinez Castro', 'ausencias' => 10, 'grado' => 'Cuarto Grado'],
            ['nombre' => 'Sofía Valentina Araya', 'ausencias' => 9, 'grado' => 'Cuarto Grado'],
        ];

        // 5. Lista de estudiantes en riesgo (bajo rendimiento)
        $atRiskStudents = [
            ['nombre' => 'Pedro Pablo Alvarado', 'promedio' => 68.5, 'grado' => 'Cuarto Grado'],
            ['nombre' => 'Laura Isabel Schmidt', 'promedio' => 69.0, 'grado' => 'Cuarto Grado'],
            ['nombre' => 'Mateo Rojas Solano', 'promedio' => 69.8, 'grado' => 'Cuarto Grado'],
        ];


        return view('reportes.index', [
            'metrics' => $metrics,
            'attendanceData' => $attendanceData,
            'gradesData' => $gradesData,
            'topAbsences' => $topAbsences,
            'atRiskStudents' => $atRiskStudents,
        ]);

        // --- FIN DE DATOS QUEMADOS ---
    }
}
