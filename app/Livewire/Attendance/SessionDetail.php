<?php

// app/Livewire/Attendance/SessionDetail.php

namespace App\Livewire\Attendance;

use App\Models\Asistencia;
use App\Models\SesionAsistencia;
use Livewire\Features\SupportRedirects\Redirector;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

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
            'cargaAcademica.maestro',
            'ciclo.tipoCiclo',
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

    public function editSession(): ?Redirector
    {
        if ($this->session) {
            // Redirige a la ruta de edición con el ID de la sesión.
            // Asegúrate de tener una ruta nombrada 'attendance.edit' en tus archivos de rutas.
            return redirect()->route('attendance.edit', $this->session->id);
        }

        return null;
    }

    public function render()
    {
        return view('livewire.attendance.session-detail');
    }
}
