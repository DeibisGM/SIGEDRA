<?php

namespace App\Livewire;

use App\Models\Estudiante;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class GestionEstudiantes extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $isReady = false;

    public function loadEstudiantes()
    {
        $this->isReady = true;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $startTime = microtime(true);

        $estudiantes = $this->isReady
            ? Estudiante::query()
                ->select('estudiante.*', DB::raw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS edad'))
                ->when($this->search, function ($query) {
                    $query->where('nombres', 'like', '%' . $this->search . '%')
                        ->orWhere('apellidos', 'like', '%' . $this->search . '%')
                        ->orWhere('codigo_estudiante', 'like', '%' . $this->search . '%');
                })
                ->paginate($this->perPage)
            : [];

        $queryEndTime = microtime(true);
        $queryDuration = ($queryEndTime - $startTime) * 1000;
        Log::info('[PROFILING] Query execution took: ' . round($queryDuration, 2) . 'ms');

        $view = view('livewire.gestion-estudiantes', [
            'estudiantes' => $estudiantes,
            'isReady' => $this->isReady,
        ]);

        $renderEndTime = microtime(true);
        $renderDuration = ($renderEndTime - $queryEndTime) * 1000;
        Log::info('[PROFILING] Blade render took: ' . round($renderDuration, 2) . 'ms');

        return $view;
    }
}