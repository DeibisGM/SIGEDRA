<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

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
    public function create(Request $request): View
    {
        $subject = $request->query('materia', 'Curso no seleccionado');
        $date = $request->query('fecha', 'Fecha no seleccionada');

        // This method displays the form to take a new attendance.
        // Datos estáticos de ejemplo
        // CAMBIO: Se elimina la clave 'seccion' para mantener consistencia
        $students = [
            ['cedula' => '123456789', 'nombre' => 'Carlos Javier Mendoza Perez', 'email' => 'carlos.mendoza@email.com', 'asistencia' => 90, 'estado' => 'Presente'],
            ['cedula' => '987654321', 'nombre' => 'Ana Sofia Rojas Vega', 'email' => 'ana.rojas@email.com', 'asistencia' => 95, 'estado' => 'Presente'],
            ['cedula' => '112233445', 'nombre' => 'Luis Alejandro Quiros', 'email' => 'luis.quiros@email.com', 'asistencia' => 85, 'estado' => 'Ausente'],
            ['cedula' => '554433221', 'nombre' => 'Maria Fernanda Solano', 'email' => 'maria.solano@email.com', 'asistencia' => 100, 'estado' => 'Presente'],
            ['cedula' => '667788990', 'nombre' => 'Jose Pablo Alvarado', 'email' => 'jose.alvarado@email.com', 'asistencia' => 90, 'estado' => 'Tardía'],
            ['cedula' => '123456789', 'nombre' => 'Carlos Javier Mendoza Perez', 'email' => 'carlos.mendoza@email.com', 'asistencia' => 90, 'estado' => 'Presente'],
            ['cedula' => '987654321', 'nombre' => 'Ana Sofia Rojas Vega', 'email' => 'ana.rojas@email.com', 'asistencia' => 95, 'estado' => 'Presente'],
            ['cedula' => '112233445', 'nombre' => 'Luis Alejandro Quiros', 'email' => 'luis.quiros@email.com', 'asistencia' => 65, 'estado' => 'Ausente'],
            ['cedula' => '554433221', 'nombre' => 'Maria Fernanda Solano', 'email' => 'maria.solano@email.com', 'asistencia' => 100, 'estado' => 'Presente'],
            ['cedula' => '667788990', 'nombre' => 'Jose Pablo Alvarado', 'email' => 'jose.alvarado@email.com', 'asistencia' => 90, 'estado' => 'Tardía'],
        ];

        return view('attendance.create', [
            'students' => $students,
            'subject' => $subject,
            'date' => $date,
        ]);
    }

    public function show(Request $request, $id)
    {
        // 1. Get filters for the "back" button
        $backFilters = $request->only(['startDate', 'endDate', 'selectedGrades', 'selectedMaterias', 'selectedMaestro']);

        // 2. Get the main session details
        $sesion = DB::table('sesion_asistencia')
            ->join('carga_academica', 'sesion_asistencia.carga_academica_id', '=', 'carga_academica.id')
            ->join('materia', 'carga_academica.materia_id', '=', 'materia.id')
            ->join('grado', 'carga_academica.grado_id', '=', 'grado.id')
            ->join('nivel_academico', 'grado.nivel_academico_id', '=', 'nivel_academico.id')
            ->join('anio_lectivo', 'grado.anio_lectivo_id', '=', 'anio_lectivo.id')
            ->join('maestro', 'carga_academica.maestro_id', '=', 'maestro.id')
            ->where('sesion_asistencia.id', $id)
            ->select(
                'sesion_asistencia.id',
                'sesion_asistencia.fecha',
                'materia.nombre as subject',
                'nivel_academico.nombre as nivel_academico_nombre',
                'anio_lectivo.anio as anio_lectivo_anio',
                DB::raw("CONCAT(maestro.primer_nombre, ' ', maestro.primer_apellido) as maestro_nombre")
            )
            ->first();

        if (!$sesion) {
            abort(404);
        }

        // 3. Get the students and their attendance for this session
        $students = DB::table('asistencia')
            ->join('estudiante', 'asistencia.estudiante_id', '=', 'estudiante.id')
            ->join('estado_asistencia', 'asistencia.estado_asistencia_id', '=', 'estado_asistencia.id')
            ->where('asistencia.sesion_asistencia_id', $id)
            ->select(
                'estudiante.id',
                'estudiante.cedula',
                DB::raw("CONCAT(estudiante.primer_nombre, ' ', COALESCE(estudiante.segundo_nombre, ''), ' ', estudiante.primer_apellido, ' ', COALESCE(estudiante.segundo_apellido, '')) as nombre_completo"),
                'estado_asistencia.nombre as estado',
                'asistencia.observaciones'
            )
            ->orderBy('estudiante.primer_apellido')
            ->get();


        return view('attendance.show', [
            'sesion' => $sesion,
            'students' => $students,
            'backFilters' => $backFilters,
        ]);
    }

}
