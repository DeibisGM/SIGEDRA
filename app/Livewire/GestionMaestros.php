<?php
namespace App\Livewire;

use App\Models\Maestro;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

// Importar Builder para las consultas

use Illuminate\Pagination\LengthAwarePaginator;

class GestionMaestros extends Component
{
    use WithPagination;

    public string $search = '';
    public string $activeFilter = 'active';
    public array $activeFilters = [];

    public function mount(): void
    {
        $this->applyFilters();
    }

    public function filterByStatus(string $status): void
    {
        $this->activeFilter = $status;
        $this->applyFilters();
    }

    public function applyFilters(): void
    {
        $this->activeFilters = [
            'search' => $this->search,
            'active' => $this->activeFilter,
        ];
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'activeFilter']);
        $this->applyFilters();
    }

    public function render()
    {
        $query = Maestro::with('user');

        if ($this->activeFilters['active'] === 'active') {
            $query->where('activo', 1);
        } elseif ($this->activeFilters['active'] === 'inactive') {
            $query->where('activo', 0);
        }

        if ($this->activeFilters['search']) {
            $searchTerms = explode(' ', $this->activeFilters['search']);
            $query->where(function (Builder $q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $q->where(function (Builder $q2) use ($term) {
                        $q2->where('primer_nombre', 'like', '%' . $term . '%')
                            ->orWhere('primer_apellido', 'like', '%' . $term . '%')
                            ->orWhere('segundo_apellido', 'like', '%' . $term . '%')
                            ->orWhereHas('user', function (Builder $qUser) use ($term) {
                                $qUser->where('cedula', 'like', '%' . $term . '%');
                            });
                    });
                }
            });
        }

        $maestros = $query->orderBy('primer_nombre')->paginate(10);

        return view('livewire.gestion-maestros', [
            'maestros' => $maestros,
        ]);
    }
}

