<?php

// app/Livewire/Attendance/AttendanceHistory.php

namespace App\Livewire\Attendance;

use App\Models\Grado;
use App\Models\Maestro;
use App\Models\Materia;
use App\Models\SesionAsistencia;
use Livewire\Component;
use Livewire\WithPagination;

class AttendanceHistory extends Component
{
    use WithPagination;

    public bool $isReady = false;

    public int $perPage = 10;



    public ?int $recordIdToDelete = null;

    public string $startDate = '';

    public string $endDate = '';

    public array $selectedGrades = [];

    public array $selectedMaterias = [];

    public array $selectedMaestros = [];

    public array $activeFilters = [];

    public ?int $newAttendanceId = null;

    public function mount(): void
    {
        $this->applyFilters();
        $this->newAttendanceId = session('new_attendance_id');
    }

    public function loadAsistencias(): void
    {
        $this->isReady = true;
    }

    public function applyFilters(): void
    {
        $this->activeFilters = [
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'selectedGrades' => $this->selectedGrades,
            'selectedMaterias' => $this->selectedMaterias,
            'selectedMaestros' => $this->selectedMaestros,
        ];
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['startDate', 'endDate', 'selectedGrades', 'selectedMaterias', 'selectedMaestros']);
        $this->applyFilters();
        $this->dispatch('filters-cleared');
    }



    public function delete(): void
    {
        try {
            if ($this->recordIdToDelete) {
                SesionAsistencia::destroy($this->recordIdToDelete);
                session()->flash('success', 'Registro de asistencia eliminado correctamente.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al eliminar el registro de asistencia.');
        }

        $this->recordIdToDelete = null;
        $this->resetPage();
        $this->dispatch('deletion-finished');
    }

    public function render()
    {
        $user = auth()->user();

        if ($user->hasRole('Maestro')) {
            $allMaterias = Materia::whereHas('cargasAcademicas.maestro', fn ($q) => $q->where('usuario_id', $user->id))->orderBy('nombre')->get();
        } else {
            $allMaterias = Materia::orderBy('nombre')->get();
        }

        $allMaestros = Maestro::where('activo', 1)->orderBy('primer_nombre')->get();
        $allGrados = Grado::with(['nivelAcademico', 'anioAcademico'])
            ->get()
            ->sortByDesc('anioAcademico.anio')
            ->groupBy('anioAcademico.anio');

        $asistencias = collect();
        if ($this->isReady) {
            $query = SesionAsistencia::query()
                ->with([
                    'cargaAcademica.materia',
                    'cargaAcademica.grado.nivelAcademico',
                    'cargaAcademica.grado.anioAcademico',
                    'cargaAcademica.maestro',
                ])
                ->withCount([
                    'asistencias as presentes_count' => fn ($q) => $q->where('estado_asistencia_id', 1),
                    'asistencias as ausentes_count' => fn ($q) => $q->where('estado_asistencia_id', 2),
                    'asistencias as tardias_count' => fn ($q) => $q->where('estado_asistencia_id', 3),
                    'asistencias as justificadas_count' => fn ($q) => $q->where('estado_asistencia_id', 4),
                    'asistencias as total_estudiantes_count',
                ])
                ->when($this->activeFilters['startDate'], fn ($q) => $q->where('fecha', '>=', $this->activeFilters['startDate']))
                ->when($this->activeFilters['endDate'], fn ($q) => $q->where('fecha', '<=', $this->activeFilters['endDate']))
                ->when($this->activeFilters['selectedGrades'], fn ($q) => $q->whereHas('cargaAcademica', fn ($sq) => $sq->whereIn('grado_id', $this->activeFilters['selectedGrades'])))
                ->when($this->activeFilters['selectedMaterias'], fn ($q) => $q->whereHas('cargaAcademica', fn ($sq) => $sq->whereIn('materia_id', $this->activeFilters['selectedMaterias'])))
                ->when($this->activeFilters['selectedMaestros'], fn ($q) => $q->whereHas('cargaAcademica', fn ($sq) => $sq->whereIn('maestro_id', $this->activeFilters['selectedMaestros'])))
                ->when($user->hasRole('Maestro'), fn ($q) => $q->whereHas('cargaAcademica.maestro', fn ($sq) => $sq->where('usuario_id', $user->id)))
                ->orderBy('fecha', 'desc')
                ->orderBy('id', 'desc');

            $asistencias = $query->paginate($this->perPage);
        }

        return view('livewire.attendance.attendance-history', [
            'asistencias' => $asistencias,
            'allGrados' => $allGrados,
            'allMaterias' => $allMaterias,
            'allMaestros' => $allMaestros,
        ]);
    }
}
