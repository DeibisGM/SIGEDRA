<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(): View
    {
        // Datos estáticos de ejemplo
        $students = [
            ['cedula' => '123456789', 'nombre' => 'Carlos Javier Mendoza Perez', 'email' => 'carlos.mendoza@email.com', 'seccion' => '7-1', 'asistencia' => 90, 'estado' => 'Presente'],
            ['cedula' => '987654321', 'nombre' => 'Ana Sofia Rojas Vega', 'email' => 'ana.rojas@email.com', 'seccion' => '7-1', 'asistencia' => 95, 'estado' => 'Presente'],
            ['cedula' => '112233445', 'nombre' => 'Luis Alejandro Quiros', 'email' => 'luis.quiros@email.com', 'seccion' => '7-1', 'asistencia' => 85, 'estado' => 'Ausente'],
            ['cedula' => '554433221', 'nombre' => 'Maria Fernanda Solano', 'email' => 'maria.solano@email.com', 'seccion' => '7-1', 'asistencia' => 100, 'estado' => 'Presente'],
            ['cedula' => '667788990', 'nombre' => 'Jose Pablo Alvarado', 'email' => 'jose.alvarado@email.com', 'seccion' => '7-1', 'asistencia' => 90, 'estado' => 'Tardía'],
        ];

        return view('attendance.index', ['students' => $students]);
    }
}
