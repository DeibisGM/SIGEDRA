<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // This method now displays the list of past attendances.
        // The actual data will be fetched from the database in the future.
        return view('attendance.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // This method displays the form to take a new attendance.
        // Datos estáticos de ejemplo
        $students = [
            ['cedula' => '123456789', 'nombre' => 'Carlos Javier Mendoza Perez', 'email' => 'carlos.mendoza@email.com', 'seccion' => '7-1', 'asistencia' => 90, 'estado' => 'Presente'],
            ['cedula' => '987654321', 'nombre' => 'Ana Sofia Rojas Vega', 'email' => 'ana.rojas@email.com', 'seccion' => '7-1', 'asistencia' => 95, 'estado' => 'Presente'],
            ['cedula' => '112233445', 'nombre' => 'Luis Alejandro Quiros', 'email' => 'luis.quiros@email.com', 'seccion' => '7-1', 'asistencia' => 85, 'estado' => 'Ausente'],
            ['cedula' => '554433221', 'nombre' => 'Maria Fernanda Solano', 'email' => 'maria.solano@email.com', 'seccion' => '7-1', 'asistencia' => 100, 'estado' => 'Presente'],
            ['cedula' => '667788990', 'nombre' => 'Jose Pablo Alvarado', 'email' => 'jose.alvarado@email.com', 'seccion' => '7-1', 'asistencia' => 90, 'estado' => 'Tardía'],
            ['cedula' => '123456789', 'nombre' => 'Carlos Javier Mendoza Perez', 'email' => 'carlos.mendoza@email.com', 'seccion' => '7-1', 'asistencia' => 90, 'estado' => 'Presente'],
            ['cedula' => '987654321', 'nombre' => 'Ana Sofia Rojas Vega', 'email' => 'ana.rojas@email.com', 'seccion' => '7-1', 'asistencia' => 95, 'estado' => 'Presente'],
            ['cedula' => '112233445', 'nombre' => 'Luis Alejandro Quiros', 'email' => 'luis.quiros@email.com', 'seccion' => '7-1', 'asistencia' => 65, 'estado' => 'Ausente'],
            ['cedula' => '554433221', 'nombre' => 'Maria Fernanda Solano', 'email' => 'maria.solano@email.com', 'seccion' => '7-1', 'asistencia' => 100, 'estado' => 'Presente'],
            ['cedula' => '667788990', 'nombre' => 'Jose Pablo Alvarado', 'email' => 'jose.alvarado@email.com', 'seccion' => '7-1', 'asistencia' => 90, 'estado' => 'Tardía'],
        ];

        return view('attendance.create', ['students' => $students]);
    }

    /**
     * Show the intermediate form for selecting course and date.
     */
    public function preCreate(): View
    {
        return view('attendance.pre-create');
    }
}
