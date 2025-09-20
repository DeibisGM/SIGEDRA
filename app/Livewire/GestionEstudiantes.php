<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Estudiante;
use Livewire\WithPagination;

class GestionEstudiantes extends Component
{
    use WithPagination;

    public bool $isReady = false;

    public function loadEstudiantes(): void
    {
        $this->isReady = true;
    }

    public function updatingPage(): void
    {
        $this->isReady = false;
    }

    public function updatedPage(): void
    {
        $this->isReady = true;
    }

    public function render()
    {
        return view('livewire.gestion-estudiantes', [
            'estudiantes' => $this->isReady ? Estudiante::paginate(10) : [],
        ]);
    }
}