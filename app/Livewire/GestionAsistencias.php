<?php

namespace App\Livewire;

use App\Models\Grado;
use App\Models\Maestro;
use App\Models\Materia;
use App\Models\SesionAsistencia;
use App\Models\Asistencia;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class GestionAsistencias extends Component
{
    use WithPagination;

    public bool $isReady = false;
    public int $perPage = 10;
    public bool $confirmingDeletion = false;
    public ?int $recordIdToDelete = null;

    // Propiedades para los filtros
    public string $startDate = '';
    public string $endDate = '';
    public array $selectedGrades = [];
    public array $selectedMaterias = [];
    public array $selectedMaestros = [];
    public array $activeFilters = [];

    // Propiedades para la vista de detalle
    public bool $isViewingSession = false;
    public ?SesionAsistencia $viewingSession = null;
    public Collection $studentDetails;

    public function mount(): void
    {
        // Inicializamos las propiedades que Livewire necesita gestionar.
        // Las colecciones de filtros ya no se cargan aquí.
        $this->studentDetails = collect();
        $this->applyFilters();
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

    public function confirmDeletion(int $id): void
    {
        $this->recordIdToDelete = $id;
        $this->confirmingDeletion = true;
    }

    public function delete(): void
    {
        if ($this->recordIdToDelete) {
            SesionAsistencia::destroy($this->recordIdToDelete);
        }
        $this->confirmingDeletion = false;
        $this->resetPage();
    }

    public function viewSession(int $sessionId): void
    {
        $this->viewingSession = SesionAsistencia::with([
            'cargaAcademica.materia',
            'cargaAcademica.grado.nivelAcademico',
            'cargaAcademica.grado.anioAcademico',
            'cargaAcademica.maestro'
        ])->find($sessionId);

        $this->studentDetails = Asistencia::where('sesion_asistencia_id', $sessionId)
            ->with(['estudiante', 'estadoAsistencia'])
            ->get()
            ->sortBy('estudiante.primer_apellido');

        $this->isViewingSession = true;
        $this->dispatch('view-changed', isViewingSession: true, sessionId: $sessionId);
    }

    #[On('close-session-view')]
    public function closeSessionView(): void
    {
        $this->isViewingSession = false;
        $this->viewingSession = null;
        $this->studentDetails = collect();
        $this->dispatch('view-changed', isViewingSession: false);
    }

    public function render()
    {
        // --- Carga de Opciones para Filtros (SOLO EN RENDER) ---
        $user = auth()->user();
        if ($user->hasRole('Maestro')) {
            $allMaterias = Materia::whereHas('cargasAcademicas.maestro', fn($q) => $q->where('usuario_id', $user->id))->orderBy('nombre')->get();
        } else {
            $allMaterias = Materia::orderBy('nombre')->get();
        }

        $allMaestros = Maestro::where('activo', 1)->orderBy('primer_nombre')->get();
        $allGrados = Grado::with(['nivelAcademico', 'anioAcademico'])
            ->get()
            ->sortByDesc('anioAcademico.anio')
            ->groupBy('anioAcademico.anio');
        // --- FIN DE CARGA DE FILTROS ---

        $asistencias = collect();
        if ($this->isReady) {
            $query = SesionAsistencia::query()
                ->with([
                    'cargaAcademica.materia',
                    'cargaAcademica.grado.nivelAcademico',
                    'cargaAcademica.grado.anioAcademico',
                    'cargaAcademica.maestro'
                ])
                ->withCount([
                    'asistencias as presentes_count' => fn($q) => $q->where('estado_asistencia_id', 1),
                    'asistencias as ausentes_count' => fn($q) => $q->where('estado_asistencia_id', 2),
                    'asistencias as tardias_count' => fn($q) => $q->where('estado_asistencia_id', 3),
                    'asistencias as justificadas_count' => fn($q) => $q->where('estado_asistencia_id', 4),
                    'asistencias as total_estudiantes_count',
                ])
                ->when($this->activeFilters['startDate'], fn($q) => $q->where('fecha', '>=', $this->activeFilters['startDate']))
                ->when($this->activeFilters['endDate'], fn($q) => $q->where('fecha', '<=', $this->activeFilters['endDate']))
                ->when($this->activeFilters['selectedGrades'], fn($q) => $q->whereHas('cargaAcademica', fn($sq) => $sq->whereIn('grado_id', $this->activeFilters['selectedGrades'])))
                ->when($this->activeFilters['selectedMaterias'], fn($q) => $q->whereHas('cargaAcademica', fn($sq) => $sq->whereIn('materia_id', $this->activeFilters['selectedMaterias'])))
                ->when($this->activeFilters['selectedMaestros'], fn($q) => $q->whereHas('cargaAcademica', fn($sq) => $sq->whereIn('maestro_id', $this->activeFilters['selectedMaestros'])))
                ->when($user->hasRole('Maestro'), fn($q) => $q->whereHas('cargaAcademica.maestro', fn($sq) => $sq->where('usuario_id', $user->id)))
                ->orderBy('fecha', 'desc');

            $asistencias = $query->paginate($this->perPage);
        }

        return view('livewire.gestion-asistencias', [
            'asistencias' => $asistencias,
            'allGrados' => $allGrados,
            'allMaterias' => $allMaterias,
            'allMaestros' => $allMaestros,
        ]);
    }
}
