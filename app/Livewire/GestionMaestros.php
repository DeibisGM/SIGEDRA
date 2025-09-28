<?php

namespace App\Livewire;

use App\Models\Maestro;
use Livewire\Component;
use Livewire\WithPagination;

class GestionMaestros extends Component
{
    use WithPagination;

    public function render()
    {
        $maestros = Maestro::with('user')->orderBy('primer_nombre')->paginate(10);
        return view('livewire.gestion-maestros', [
            'maestros' => $maestros,
        ]);
    }
}