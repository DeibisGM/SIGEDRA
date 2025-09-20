<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Estudiante;
use App\Models\Grado;
use App\Models\AnioAcademico;
use Illuminate\Support\Collection;

class GestionEstudiantes extends Component
{
    use WithPagination;

    // Propiedades vinculadas a los filtros de la vista
    public string $search = '';
    public string $anio_academico_id = '';
    public string $grado_id = '';

    // Propiedades para almacenar los datos de los dropdowns
    public Collection $aniosAcademicos;
    public Collection $grados;

    /**
     * El método mount se ejecuta una sola vez, cuando el componente es inicializado.
     * Es el lugar perfecto para cargar datos que no cambian, como la lista de años académicos.
     */
    public function mount(): void
    {
        $this->aniosAcademicos = AnioAcademico::orderBy('anio', 'desc')->get();
        $this->grados = collect(); // Inicializa la colección de grados vacía
    }

    /**
     * Este "gancho" (hook) de Livewire se ejecuta automáticamente cada vez que una
     * propiedad pública (como search, anio_academico_id) está a punto de ser actualizada.
     */
    public function updating($property): void
    {
        // Si el usuario cambia un filtro, lo enviamos de vuelta a la primera página de resultados.
        if (in_array($property, ['search', 'anio_academico_id', 'grado_id'])) {
            $this->resetPage();
        }
    }

    /**
     * Este método se ejecuta cuando la propiedad $anio_academico_id cambia.
     * Se encarga de actualizar dinámicamente el dropdown de grados.
     */
    public function updatedAnioAcademicoId($value): void
    {
        if ($value) {
            $this->grados = Grado::where('anio_academico_id', $value)
                ->with('nivelAcademico') // Precargamos el nombre del nivel para mostrarlo
                ->orderBy('id')
                ->get();
        } else {
            $this->grados = collect(); // Si no hay año seleccionado, vaciamos los grados
        }
        $this->reset('grado_id'); // Reseteamos la selección de grado

        $this->dispatch('options-updated', $this->grados->map(fn($grado) => ['id' => $grado->id, 'text' => $grado->nivelAcademico->nombre])->toArray());
    }

    /**
     * Elimina un estudiante de la base de datos.
     */
    public function deleteStudent(int $studentId): void
    {
        $student = Estudiante::find($studentId);
        if ($student) {
            $student->delete();
            // Opcional: puedes añadir una notificación de éxito aquí.
        }
    }

    public bool $isReady = false;

    public function loadEstudiantes(): void
    {
        $this->isReady = true;
    }

    /**
     * El método render es el responsable de generar la vista. Se ejecuta en la carga inicial
     * y cada vez que una propiedad pública cambia.
     */
    public function render()
    {
        $estudiantes = collect();

        if ($this->isReady) {
            // 1. Iniciar la consulta base
            $query = Estudiante::query();

            // 2. Aplicar filtro de búsqueda si existe
            if ($this->search) {
                $query->where(function ($q) {
                    $searchTerm = '%' . $this->search . '%';
                    $q->where('cedula', 'like', $searchTerm)
                        ->orWhere('primer_nombre', 'like', $searchTerm)
                        ->orWhere('primer_apellido', 'like', $searchTerm)
                        ->orWhereRaw("CONCAT(primer_nombre, ' ', primer_apellido) LIKE ?", [$searchTerm]);
                });
            }

            // 3. Aplicar filtros de año y grado usando una relación
            // Esto es mucho más eficiente que hacer múltiples consultas.
            if ($this->anio_academico_id || $this->grado_id) {
                $query->whereHas('grados', function ($q) {
                    if ($this->anio_academico_id) {
                        $q->where('anio_academico_id', $this->anio_academico_id);
                    }
                    if ($this->grado_id) {
                        $q->where('grado.id', $this->grado_id);
                    }
                });
            }

            // 4. Ejecutar la consulta con "Eager Loading" y paginación
            // `with([...])` es la clave para el rendimiento. Evita el problema N+1.
            $estudiantes = $query->with(['grados.nivelAcademico', 'grados.anioAcademico'])
                ->latest('id')
                ->paginate(10); // Muestra 10 estudiantes por página
        }

        return view('livewire.gestion-estudiantes', [
            'estudiantes' => $estudiantes,
        ]);
    }
}
