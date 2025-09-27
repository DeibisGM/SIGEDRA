<?php

namespace App\Livewire;

use App\Models\Estudiante;
use Livewire\Component;
use Livewire\WithPagination;

class GestionEstudiantes extends Component
{
    use WithPagination;

    public bool $isReady = false;
    public int $perPage = 10;
    public string $search = '';

    public function loadEstudiantes(): void
    {
        $this->isReady = true;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $estudiantes = $this->isReady
            ? Estudiante::query()
                ->when($this->search, function ($query) {
                    $query->where('primer_nombre', 'like', '%' . $this->search . '%')
                        ->orWhere('primer_apellido', 'like', '%' . $this->search . '%')
                        ->orWhere('cedula', 'like', '%' . $this->search . '%');
                })
                ->paginate($this->perPage)
            : [];

        return view('livewire.gestion-estudiantes', [
            'estudiantes' => $estudiantes,
        ]);
    }
}
