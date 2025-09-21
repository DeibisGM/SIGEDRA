<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GestionAsistencias extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $isReady = false;

    public function loadAsistencias()
    {
        $this->isReady = true;
    }

    public function updatingSearch()
    {
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
                    'grado'
                )
                ->orderBy('sesion_asistencia.fecha', 'desc');

            if ($this->search) {
                $query->where(function ($q) {
                    $q->where('materia.nombre', 'like', '%' . $this->search . '%')
                      ->orWhere('sesion_asistencia.fecha', 'like', '%' . $this->search . '%');
                });
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
