<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ReporteController extends Controller
{
    public function index(): View
    {
        // NOTA: Estos datos son de ejemplo. En una aplicación real,
        // se calcularían a partir de consultas a la base de datos.

        $metrics = [
            'total_students' => 124,
            'average_attendance' => 92,
            'approved_students' => 116,
            'at_risk_students' => 8,
        ];

        $attendanceData = [
            'labels' => ['Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul'],
            'datasets' => [
                ['label' => 'Presente', 'data' => [95, 96, 91, 93, 89, 92]],
                ['label' => 'Ausente', 'data' => [5, 4, 9, 7, 11, 8]],
            ],
        ];

        $gradesData = [
            'labels' => ['Sobresaliente', 'Notable', 'Suficiente', 'En Riesgo'],
            'datasets' => [['data' => [60, 35, 21, 8]]],
        ];

        $topAbsences = [
            ['nombre' => 'Carlos González', 'ausencias' => 12],
            ['nombre' => 'Luis Martinez', 'ausencias' => 10],
            ['nombre' => 'Sofía Araya', 'ausencias' => 9],
        ];

        $atRiskStudents = [
            ['nombre' => 'Pedro Alvarado', 'promedio' => 68.5],
            ['nombre' => 'Laura Schmidt', 'promedio' => 69.0],
            ['nombre' => 'Mateo Rojas', 'promedio' => 69.8],
        ];

        return view('reportes.index', compact('metrics', 'attendanceData', 'gradesData', 'topAbsences', 'atRiskStudents'));
    }
}
