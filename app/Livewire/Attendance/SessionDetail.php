<?php

namespace App\Livewire\Attendance;

use App\Models\SesionAsistencia;
use App\Models\Asistencia;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Attributes\On;

class SessionDetail extends Component
{
    public ?SesionAsistencia $session = null;
    public Collection $studentDetails;

    public function mount(): void
    {
        $this->studentDetails = collect();
    }

    #[On('load-session')]
    public function loadSession(int $sessionId): void
    {
        $this->session = SesionAsistencia::with([
            'cargaAcademica.materia',
            'cargaAcademica.grado.nivelAcademico',
            'cargaAcademica.grado.anioAcademico',
            'cargaAcademica.maestro'
        ])->find($sessionId);

        if ($this->session) {
            $this->studentDetails = Asistencia::where('sesion_asistencia_id', $sessionId)
                ->with(['estudiante', 'estadoAsistencia'])
                ->get()
                ->sortBy('estudiante.primer_apellido');
        }
    }

    public function closeSession(): void
    {
        $this->dispatch('close-session');
        $this->reset('session');
        $this->studentDetails = collect();
    }

    public function editSession(): void
    {
        if ($this->session) {
            // Lógica para redirigir o abrir modal de edición
        }
    }

    public function render()
    {
        return view('livewire.attendance.session-detail');
    }
}
