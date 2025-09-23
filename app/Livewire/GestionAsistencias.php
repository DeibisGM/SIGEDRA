<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GestionAsistencias extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $isReady = false;

    // Properties for form binding
    public $startDate = '';
    public $endDate = '';
    public $selectedGrades = [];
    public $selectedMaterias = [];
    public $selectedMaestro = '';

    // Properties for active filters
    public $activeFilters = [];

    public $totalRecords;
    public $filteredRecords;

    public $confirmingDeletion = false;
    public $recordIdToDelete;

    // Filter options
    public $allGrados = [];
    public $allMaterias = [];
    public $allMaestros = [];

    public function mount()
    {
        $user = auth()->user();
        if ($user->hasRole('Maestro')) {
            $this->allMaterias = DB::table('materia')
                ->join('carga_academica', 'materia.id', '=', 'carga_academica.materia_id')
                ->join('maestro', 'carga_academica.maestro_id', '=', 'maestro.id')
                ->where('maestro.usuario_id', $user->id)
                ->select('materia.id', 'materia.nombre')
                ->distinct()
                ->orderBy('materia.nombre')
                ->get();
        } else {
            $this->allMaterias = DB::table('materia')->orderBy('nombre')->get();
        }

        $this->allMaestros = DB::table('maestro')
            ->where('activo', 1)
            ->select('id', DB::raw("CONCAT(primer_nombre, ' ', primer_apellido) as nombre_completo"))
            ->orderBy('nombre_completo')
            ->get();

        $gradosData = DB::table('grado')
            ->join('nivel_academico', 'grado.nivel_academico_id', '=', 'nivel_academico.id')
            ->join('anio_lectivo', 'grado.anio_lectivo_id', '=', 'anio_lectivo.id')
            ->select('grado.id', 'nivel_academico.nombre', 'anio_lectivo.anio', 'nivel_academico.orden')
            ->orderBy('anio_lectivo.anio', 'desc')
            ->orderBy('nivel_academico.orden', 'asc')
            ->get();

        $this->allGrados = $gradosData->groupBy('anio');

        $user = auth()->user();
        $query = DB::table('sesion_asistencia')
            ->join('carga_academica', 'sesion_asistencia.carga_academica_id', '=', 'carga_academica.id')
            ->join('maestro', 'carga_academica.maestro_id', '=', 'maestro.id');

        if ($user->hasRole('Maestro')) {
            $query->where('maestro.usuario_id', $user->id);
        }
        $this->totalRecords = $query->distinct('sesion_asistencia.id')->count('sesion_asistencia.id');


        $this->applyFilters(); // Apply empty filters on initial load
    }

    public function loadAsistencias()
    {
        $this->isReady = true;
    }

    public function applyFilters()
    {
        $this->activeFilters = [
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'selectedGrades' => $this->selectedGrades,
            'selectedMaterias' => $this->selectedMaterias,
            'selectedMaestro' => $this->selectedMaestro,
        ];
        $this->resetPage();
    }

    public function confirmDeletion($id)
    {
        $this->recordIdToDelete = $id;
        $this->confirmingDeletion = true;
    }

    public function delete()
    {
        // First delete related attendance records
        DB::table('asistencia')->where('sesion_asistencia_id', $this->recordIdToDelete)->delete();
        DB::table('sesion_asistencia')->where('id', $this->recordIdToDelete)->delete();

        $this->confirmingDeletion = false;
    }

    public function clearFilters()
    {
        $this->startDate = '';
        $this->endDate = '';
        $this->selectedGrades = [];
        $this->selectedMaterias = [];
        $this->selectedMaestro = '';

        $this->applyFilters();
    }

    public function render()
    {
        $asistencias = [];
        if ($this->isReady) {
            $startTime = microtime(true);

            $query = DB::table('sesion_asistencia')
                ->join('carga_academica', 'sesion_asistencia.carga_academica_id', '=', 'carga_academica.id')
                ->join('materia', 'carga_academica.materia_id', '=', 'materia.id')
                ->join('grado', 'carga_academica.grado_id', '=', 'grado.id')
                ->join('nivel_academico', 'grado.nivel_academico_id', '=', 'nivel_academico.id')
                ->join('anio_lectivo', 'grado.anio_lectivo_id', '=', 'anio_lectivo.id')
                ->join('maestro', 'carga_academica.maestro_id', '=', 'maestro.id')
                ->select(
                    'sesion_asistencia.id',
                    'sesion_asistencia.fecha',
                    'materia.nombre as curso',
                    'nivel_academico.nombre as nivel_academico_nombre',
                    'anio_lectivo.anio as anio_lectivo_anio',
                    'maestro.primer_nombre as maestro_primer_nombre',
                    'maestro.primer_apellido as maestro_primer_apellido',
                    'carga_academica.grado_id',
                    'carga_academica.materia_id',
                    'carga_academica.maestro_id',
                    DB::raw("SUM(CASE WHEN asistencia.estado_asistencia_id = 1 THEN 1 ELSE 0 END) as presentes"), // Presente
                    DB::raw("SUM(CASE WHEN asistencia.estado_asistencia_id = 3 THEN 1 ELSE 0 END) as tardias"), // Tardía
                    DB::raw("SUM(CASE WHEN asistencia.estado_asistencia_id = 2 THEN 1 ELSE 0 END) as ausentes"), // Ausente
                    DB::raw("COUNT(asistencia.id) as total_estudiantes")
                )
                ->leftJoin('asistencia', 'asistencia.sesion_asistencia_id', '=', 'sesion_asistencia.id')
                ->groupBy(
                    'sesion_asistencia.id',
                    'sesion_asistencia.fecha',
                    'materia.nombre',
                    'nivel_academico.nombre',
                    'anio_lectivo.anio',
                    'maestro.primer_nombre',
                    'maestro.primer_apellido',
                    'carga_academica.grado_id',
                    'carga_academica.materia_id',
                    'carga_academica.maestro_id'
                )
                ->orderBy('sesion_asistencia.fecha', 'desc');

            // Apply filters
            if ($this->activeFilters['startDate']) {
                $query->where('sesion_asistencia.fecha', '>=', $this->activeFilters['startDate']);
            }
            if ($this->activeFilters['endDate']) {
                $query->where('sesion_asistencia.fecha', '<=', $this->activeFilters['endDate']);
            }
            if (!empty($this->activeFilters['selectedGrades'])) {
                $query->whereIn('carga_academica.grado_id', $this->activeFilters['selectedGrades']);
            }
            if (!empty($this->activeFilters['selectedMaterias'])) {
                $query->whereIn('carga_academica.materia_id', $this->activeFilters['selectedMaterias']);
            }
            if ($this->activeFilters['selectedMaestro']) {
                $query->where('carga_academica.maestro_id', $this->activeFilters['selectedMaestro']);
            }

            $user = auth()->user();
            if ($user->hasRole('Maestro')) {
                $query->where('maestro.usuario_id', $user->id);
            }

            // Get filtered records count before pagination
            $this->filteredRecords = $query->clone()->count();

            $asistencias = $query->paginate($this->perPage);

            $queryEndTime = microtime(true);
            $queryDuration = ($queryEndTime - $startTime) * 1000;
            Log::info('[PROFILING] Attendance query execution took: ' . round($queryDuration, 2) . 'ms');
        }

        return view('livewire.gestion-asistencias', [
            'asistencias' => $asistencias,
        ]);
    }
}
