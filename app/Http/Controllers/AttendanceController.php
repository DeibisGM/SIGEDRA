<?php

// app/Http/Controllers/AttendanceController.php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\CargaAcademica;
use App\Models\SesionAsistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse; // Importar RedirectResponse

class AttendanceController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $cargasAcademicas = collect();

        if ($user->hasRole('Maestro')) {
            $cargasAcademicas = CargaAcademica::where('maestro_id', $user->maestro->id)
                ->with(['materia', 'grado.nivelAcademico', 'grado.anioAcademico'])
                ->get();
        }

        $tiposCiclo = DB::table('tipo_ciclo')->get();

        return view('attendance.index', [
            'cargasAcademicas' => $cargasAcademicas,
            'tiposCiclo' => $tiposCiclo,
        ]);
    }

    public function create(Request $request): View
    {
        $validated = $request->validate([
            'carga_academica_id' => 'required|exists:carga_academica,id',
            'tipo_ciclo_id' => 'required|exists:tipo_ciclo,id',
            'fecha' => 'required|date_format:Y-m-d',
        ]);

        $cargaAcademicaId = $validated['carga_academica_id'];
        $fecha = $validated['fecha'];
        $tipoCicloId = $validated['tipo_ciclo_id'];

        $cargaAcademica = CargaAcademica::with(['materia', 'grado.nivelAcademico', 'grado.anioAcademico'])->findOrFail($cargaAcademicaId);

        $user = Auth::user();
        if ($user->hasRole('Maestro') && $cargaAcademica->maestro_id !== $user->maestro->id) {
            abort(403, 'No tienes permiso para acceder a este curso.');
        }

        // Buscar el ciclo_id
        $ciclo = DB::table('ciclo')
            ->where('grado_id', $cargaAcademica->grado_id)
            ->where('tipo_ciclo_id', $tipoCicloId)
            ->where('activo', 1)
            ->first();

        if (!$ciclo) {
            abort(404, 'No se encontró un ciclo activo para el grado y tipo de ciclo especificado.');
        }

        $tipoCiclo = DB::table('tipo_ciclo')->find($tipoCicloId);

        $students = \App\Models\Estudiante::whereHas('grados', function ($query) use ($cargaAcademica) {
            $query->where('grado.id', $cargaAcademica->grado_id);
        })->orderBy('primer_apellido')->orderBy('segundo_apellido')->orderBy('primer_nombre')->get();

        return view('attendance.create', [
            'cargaAcademica' => $cargaAcademica,
            'students' => $students,
            'fecha' => $fecha,
            'ciclo_id' => $ciclo->id,
            'cicloNombre' => $tipoCiclo->nombre,
        ]);
    }

    /**
     * Almacena una nueva sesión de asistencia en la base de datos.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'carga_academica_id' => 'required|exists:carga_academica,id',
            'ciclo_id' => 'required|exists:ciclo,id',
            'fecha' => 'required|date',
            'asistencias' => 'required|array',
            'asistencias.*.estado_asistencia_id' => 'required|exists:estado_asistencia,id',
            'asistencias.*.observaciones' => 'nullable|string|max:255',
        ]);

        $sesionAsistencia = null;

        // Usamos una transacción para asegurar la integridad de los datos.
        DB::transaction(function () use ($validated, &$sesionAsistencia) {
            // 1. Crear la sesión de asistencia
            $sesionAsistencia = SesionAsistencia::create([
                'carga_academica_id' => $validated['carga_academica_id'],
                'ciclo_id' => $validated['ciclo_id'],
                'fecha' => $validated['fecha'],
            ]);

            // 2. Iterar y guardar la asistencia de cada estudiante
            foreach ($validated['asistencias'] as $estudiante_id => $data) {
                Asistencia::create([
                    'sesion_asistencia_id' => $sesionAsistencia->id,
                    'estudiante_id' => $estudiante_id,
                    'estado_asistencia_id' => $data['estado_asistencia_id'],
                    'observaciones' => $data['observaciones'] ?? null,
                ]);
            }
        });

        // 3. Redirigir al historial con un mensaje de éxito y el ID de la nueva asistencia
        return redirect()->route('attendance.index')
            ->with('success', 'Asistencia guardada correctamente.')
            ->with('new_attendance_id', $sesionAsistencia->id);
    }


    /**
     * Muestra el formulario para editar una sesión de asistencia existente.
     */
    public function edit(SesionAsistencia $sesionAsistencia): View
    {
        // Esta lógica necesitará ser desarrollada para la vista de edición.
        return view('attendance.edit', ['session' => $sesionAsistencia]);
    }
}
