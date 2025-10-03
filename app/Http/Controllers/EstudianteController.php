<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Grado;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class EstudianteController extends Controller
{
    /**
     * Muestra la lista de estudiantes (usa Livewire)
     */
    public function index(): View
    {
        return view('estudiantes.index');
    }

    /**
     * Muestra el formulario para crear un nuevo estudiante
     */
    public function create(): View
    {
        // Obtener todos los grados activos para el combobox
        $grados = Grado::where('activo', true)
            ->with('nivelAcademico')
            ->orderBy('nivel_academico_id')
            ->get();

        return view('estudiantes.create', compact('grados'));
    }

    /**
     * Guarda un nuevo estudiante y lo asigna a un grado
     */
    public function store(Request $request): RedirectResponse
    {
        // Validación
        $validated = $request->validate([
            // Datos de identidad
            'cedula' => 'required|string|max:20|unique:estudiante,cedula',

            // Datos personales
            'primer_nombre' => 'required|string|max:100',
            'segundo_nombre' => 'nullable|string|max:100',
            'primer_apellido' => 'required|string|max:100',
            'segundo_apellido' => 'nullable|string|max:100',
            'fecha_nacimiento' => 'required|date|before:today|after:1900-01-01',
            'genero' => 'required|in:M,F,O',
            'nacionalidad' => 'nullable|string|max:100',

            // Dirección
            'provincia' => 'nullable|string|max:100',
            'canton' => 'nullable|string|max:100',
            'distrito' => 'nullable|string|max:100',
            'direccion_exacta' => 'nullable|string|max:500',

            // Asignación académica
            'grado_id' => 'required|exists:grado,id',

            // Adecuación curricular
            'necesita_adecuacion' => 'nullable|boolean',
            'adecuacion_id' => 'required_if:necesita_adecuacion,1|nullable|exists:adecuacion,id',
            'adecuacion_detalles' => 'nullable|string|max:1000',
        ], [
            'cedula.required' => 'La cédula es obligatoria.',
            'cedula.unique' => 'Esta cédula ya está registrada en el sistema.',
            'primer_nombre.required' => 'El primer nombre es obligatorio.',
            'primer_apellido.required' => 'El primer apellido es obligatorio.',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
            'genero.required' => 'El género es obligatorio.',
            'genero.in' => 'El género seleccionado no es válido.',
            'grado_id.required' => 'Debe seleccionar un grado para el estudiante.',
            'grado_id.exists' => 'El grado seleccionado no es válido.',
            'adecuacion_id.required_if' => 'Debe seleccionar el tipo de adecuación.',
        ]);

        try {
            DB::beginTransaction();

            // Construir dirección completa
            $direccion_completa = $this->construirDireccion(
                $validated['provincia'] ?? null,
                $validated['canton'] ?? null,
                $validated['distrito'] ?? null,
                $validated['direccion_exacta'] ?? null
            );

            // 1. Crear el estudiante
            $estudiante = Estudiante::create([
                'cedula' => $validated['cedula'],
                'primer_nombre' => ucfirst(strtolower(trim($validated['primer_nombre']))),
                'segundo_nombre' => $validated['segundo_nombre']
                    ? ucfirst(strtolower(trim($validated['segundo_nombre'])))
                    : null,
                'primer_apellido' => ucfirst(strtolower(trim($validated['primer_apellido']))),
                'segundo_apellido' => $validated['segundo_apellido']
                    ? ucfirst(strtolower(trim($validated['segundo_apellido'])))
                    : null,
                'fecha_nacimiento' => $validated['fecha_nacimiento'],
                'genero' => $validated['genero'],
                'nacionalidad' => $validated['nacionalidad'] ?? null,
                'direccion' => $direccion_completa,
                'activo' => true,
            ]);

            // 2. Asignar el estudiante al grado seleccionado
            $estudiante->grados()->attach($validated['grado_id']);

            // 3. Guardar adecuación si aplica
            if ($request->boolean('necesita_adecuacion') && ! empty($validated['adecuacion_id'])) {
                DB::table('asignacion_estudiante_adecuacion')->insert([
                    'estudiante_id' => $estudiante->id,
                    'adecuacion_id' => $validated['adecuacion_id'],
                    'nivel' => $validated['adecuacion_detalles'] ?? null,
                    'fecha_asignacion' => Carbon::now(),
                    'activo' => true,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('estudiantes.show', $estudiante)
                ->with('success', "¡Estudiante {$estudiante->nombre_completo} registrado exitosamente!");

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error al crear estudiante', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al registrar el estudiante. Por favor, intente nuevamente.');
        }
    }

    /**
     * Muestra los detalles de un estudiante específico
     */
    public function show(Estudiante $estudiante): View
    {
        // Cargar relaciones necesarias
        $estudiante->load([
            'grados.nivelAcademico',
            'grados.anioAcademico',
        ]);

        // Obtener grado actual (el último asignado)
        $grado_actual = $estudiante->grados()->first();

        return view('estudiantes.show', [
            'student' => $estudiante,
            'grado_actual' => $grado_actual,
        ]);
    }

    /**
     * Muestra el formulario para editar un estudiante
     */
    public function edit(Estudiante $estudiante): View
    {
        // Obtener grados activos para el combobox
        $grados = Grado::where('activo', true)
            ->with('nivelAcademico')
            ->orderBy('nivel_academico_id')
            ->get();

        // Obtener grado actual del estudiante
        $grado_actual = $estudiante->gradoActual()->first();

        // Separar la dirección si está en un solo campo
        $direccion_partes = $this->separarDireccion($estudiante->direccion);

        return view('estudiantes.edit', compact('estudiante', 'grados', 'grado_actual', 'direccion_partes'));
    }

    /**
     * Actualiza los datos de un estudiante
     */
    public function update(Request $request, Estudiante $estudiante): RedirectResponse
    {
        // Validación (cédula única excepto para el estudiante actual)
        $validated = $request->validate([
            'cedula' => 'required|string|max:20|unique:estudiante,cedula,'.$estudiante->id,
            'primer_nombre' => 'required|string|max:100',
            'segundo_nombre' => 'nullable|string|max:100',
            'primer_apellido' => 'required|string|max:100',
            'segundo_apellido' => 'nullable|string|max:100',
            'fecha_nacimiento' => 'required|date|before:today|after:1900-01-01',
            'genero' => 'required|in:M,F,O',
            'nacionalidad' => 'nullable|string|max:100',
            'provincia' => 'nullable|string|max:100',
            'canton' => 'nullable|string|max:100',
            'distrito' => 'nullable|string|max:100',
            'direccion_exacta' => 'nullable|string|max:500',
            'grado_id' => 'nullable|exists:grado,id',
            'activo' => 'nullable|boolean',
        ], [
            'cedula.unique' => 'Esta cédula ya está registrada en el sistema.',
            'primer_nombre.required' => 'El primer nombre es obligatorio.',
            'primer_apellido.required' => 'El primer apellido es obligatorio.',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'genero.required' => 'El género es obligatorio.',
        ]);

        try {
            DB::beginTransaction();

            // Construir dirección
            $direccion_completa = $this->construirDireccion(
                $validated['provincia'] ?? null,
                $validated['canton'] ?? null,
                $validated['distrito'] ?? null,
                $validated['direccion_exacta'] ?? null
            );

            // Actualizar el estudiante
            $estudiante->update([
                'cedula' => $validated['cedula'],
                'primer_nombre' => ucfirst(strtolower(trim($validated['primer_nombre']))),
                'segundo_nombre' => $validated['segundo_nombre']
                    ? ucfirst(strtolower(trim($validated['segundo_nombre'])))
                    : null,
                'primer_apellido' => ucfirst(strtolower(trim($validated['primer_apellido']))),
                'segundo_apellido' => $validated['segundo_apellido']
                    ? ucfirst(strtolower(trim($validated['segundo_apellido'])))
                    : null,
                'fecha_nacimiento' => $validated['fecha_nacimiento'],
                'genero' => $validated['genero'],
                'nacionalidad' => $validated['nacionalidad'] ?? null,
                'direccion' => $direccion_completa,
                'activo' => $request->has('activo') ? true : false,
            ]);

            // Manejar cambio de grado
            if (! empty($validated['grado_id'])) {
                $grado_actual = $estudiante->grados()->first();

                // Solo actualizar si es diferente al actual
                if (! $grado_actual || $grado_actual->id != $validated['grado_id']) {
                    // Eliminar el grado actual
                    if ($grado_actual) {
                        $estudiante->grados()->detach($grado_actual->id);
                    }

                    // Asignar el nuevo grado
                    $estudiante->grados()->attach($validated['grado_id']);
                }
            }

            DB::commit();

            return redirect()
                ->route('estudiantes.show', $estudiante)
                ->with('success', 'Estudiante actualizado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error al actualizar estudiante', [
                'error' => $e->getMessage(),
                'estudiante_id' => $estudiante->id,
            ]);

            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al actualizar el estudiante. Por favor, intente nuevamente.');
        }
    }

    /**
     * Desactiva un estudiante (soft delete lógico)
     */
    public function destroy(Estudiante $estudiante): RedirectResponse
    {
        try {
            // Desactivar estudiante (soft delete lógico)
            $estudiante->update(['activo' => false]);

            Log::info('Estudiante desactivado', [
                'estudiante_id' => $estudiante->id,
                'nombre' => $estudiante->nombre_completo,
                'usuario' => auth()->id() ?? 'system',
            ]);

            return redirect()
                ->route('estudiantes.index')
                ->with('success', 'Estudiante desactivado exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error al desactivar estudiante', [
                'error' => $e->getMessage(),
                'estudiante_id' => $estudiante->id,
            ]);

            return back()
                ->with('error', 'Ocurrió un error al desactivar el estudiante. Por favor, intente nuevamente.');
        }
    }

    /**
     * Reactiva un estudiante desactivado
     */
    public function restore(Estudiante $estudiante): RedirectResponse
    {
        try {
            $estudiante->update(['activo' => true]);

            Log::info('Estudiante reactivado', [
                'estudiante_id' => $estudiante->id,
                'usuario' => auth()->id() ?? 'system',
            ]);

            return redirect()
                ->route('estudiantes.show', $estudiante)
                ->with('success', 'Estudiante reactivado exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error al reactivar estudiante: '.$e->getMessage());

            return back()
                ->with('error', 'Ocurrió un error al reactivar el estudiante.');
        }
    }

    /**
     * Búsqueda de estudiante por cédula (API para AJAX)
     */
    public function buscarPorCedula(Request $request)
    {
        $request->validate([
            'cedula' => 'required|string',
        ]);

        $estudiante = Estudiante::where('cedula', $request->cedula)
            ->with('gradoActual')
            ->first();

        if ($estudiante) {
            return response()->json([
                'encontrado' => true,
                'estudiante' => [
                    'id' => $estudiante->id,
                    'cedula' => $estudiante->cedula,
                    'nombre_completo' => $estudiante->nombre_completo,
                    'primer_nombre' => $estudiante->primer_nombre,
                    'segundo_nombre' => $estudiante->segundo_nombre,
                    'primer_apellido' => $estudiante->primer_apellido,
                    'segundo_apellido' => $estudiante->segundo_apellido,
                    'fecha_nacimiento' => $estudiante->fecha_nacimiento->format('Y-m-d'),
                    'edad' => $estudiante->edad,
                    'genero' => $estudiante->genero,
                    'nacionalidad' => $estudiante->nacionalidad,
                    'direccion' => $estudiante->direccion,
                    'activo' => $estudiante->activo,
                    'grado_actual' => optional($estudiante->gradoActual()->first())->nombre,
                ],
            ]);
        }

        return response()->json([
            'encontrado' => false,
            'mensaje' => 'No se encontró ningún estudiante con esa cédula.',
        ]);
    }

    /**
     * Construye la dirección completa a partir de los campos individuales
     */
    private function construirDireccion(?string $provincia, ?string $canton, ?string $distrito, ?string $direccion_exacta): ?string
    {
        $partes = array_filter([
            $provincia,
            $canton,
            $distrito,
            $direccion_exacta,
        ]);

        return ! empty($partes) ? implode(', ', $partes) : null;
    }

    /**
     * Separa la dirección en sus componentes (para edición)
     */
    private function separarDireccion(?string $direccion): array
    {
        if (empty($direccion)) {
            return [
                'provincia' => null,
                'canton' => null,
                'distrito' => null,
                'direccion_exacta' => null,
            ];
        }

        // Intentar separar por comas (si se guardó con el formato estándar)
        $partes = array_map('trim', explode(',', $direccion));

        return [
            'provincia' => $partes[0] ?? null,
            'canton' => $partes[1] ?? null,
            'distrito' => $partes[2] ?? null,
            'direccion_exacta' => $partes[3] ?? null,
        ];
    }
}
