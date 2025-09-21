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

    // Filter properties
    public $startDate = '';
    public $endDate = '';
    public $selectedGrades = [];
    public $selectedMaterias = [];

    // Filter options
    public $allGrados = [];
    public $allMaterias = [];

    public function mount()
    {
        $this->allGrados = DB::table('grado')
            ->join('nivel_academico', 'grado.nivel_academico_id', '=', 'nivel_academico.id')
            ->join('anio_lectivo', 'grado.anio_lectivo_id', '=', 'anio_lectivo.id')
            ->select('grado.id', DB::raw("CONCAT(nivel_academico.nombre, ' ', anio_lectivo.anio) as nombre"))
            ->orderBy('nombre')
            ->get();

        $this->allMaterias = DB::table('materia')->orderBy('nombre')->get();
    }

    public function loadAsistencias()
    {
        $this->isReady = true;
    }

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->startDate = '';
        $this->endDate = '';
        $this->selectedGrades = [];
        $this->selectedMaterias = [];
        $this->resetPage();
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
                ->select(
                    'sesion_asistencia.id',
                    'sesion_asistencia.fecha',
                    'materia.nombre as curso',
                    DB::raw("CONCAT(nivel_academico.nombre, ' ', anio_lectivo.anio) as grado"),
                    'carga_academica.grado_id',
                    'carga_academica.materia_id',
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
                    'grado',
                    'carga_academica.grado_id',
                    'carga_academica.materia_id'
                )
                ->orderBy('sesion_asistencia.fecha', 'desc');

            // Apply filters
            if ($this->startDate) {
                $query->where('sesion_asistencia.fecha', '>=', $this->startDate);
            }
            if ($this->endDate) {
                $query->where('sesion_asistencia.fecha', '<=', $this->endDate);
            }
            if (!empty($this->selectedGrades)) {
                $query->whereIn('carga_academica.grado_id', $this->selectedGrades);
            }
            if (!empty($this->selectedMaterias)) {
                $query->whereIn('carga_academica.materia_id', $this->selectedMaterias);
            }


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
