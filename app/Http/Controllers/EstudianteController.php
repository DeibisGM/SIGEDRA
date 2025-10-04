<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Grado;
use Carbon\Carbon;
use App\Models\Adecuacion;
use App\Http\Requests\EstudianteRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
    public function create()
    {
        $grados = Grado::where('activo', true)
            ->with('nivelAcademico')
            ->orderBy('nivel_academico_id')
            ->get();

        $adecuaciones = Adecuacion::orderBy('nombre')->get();

        return view('estudiantes.create', compact('grados', 'adecuaciones'));
    }

    /**
     * Guarda un nuevo estudiante y lo asigna a un grado
     */
    public function store(EstudianteRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $direccion_completa = $this->construirDireccion(
                $validated['provincia'] ?? null,
                $validated['canton'] ?? null,
                $validated['distrito'] ?? null,
                $validated['direccion_exacta'] ?? null
            );

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
                'activo' => $request->has('activo'),
            ]);

            // Asignar grado
            $estudiante->grados()->attach($validated['grado_id']);

            // Asignar adecuación si existe
            if ($request->boolean('tiene_adecuacion') && !empty($validated['adecuacion_id'])) {
                $estudiante->adecuaciones()->attach($validated['adecuacion_id'], [
                    'nivel' => $validated['nivel_adecuacion'],
                    'fecha_asignacion' => $validated['fecha_asignacion_adecuacion'],
                    'activo' => $request->has('adecuacion_activa'),
                ]);
            }

            DB::commit();

            return redirect()
                ->route('estudiantes.show', $estudiante)
                ->with('success', 'Estudiante registrado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error al crear estudiante', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
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

        // Obtener todas las adecuaciones disponibles
        $adecuaciones = Adecuacion::orderBy('nombre')->get();

        // Obtener grado actual del estudiante
        $grado_actual = $estudiante->gradoActual()->first();

        // Obtener la adecuación actual del estudiante (si tiene)
        $adecuacion_actual = $estudiante->adecuacionesActivas()->first();

        // Separar la dirección si está en un solo campo
        $direccion_partes = $this->separarDireccion($estudiante->direccion);

        return view('estudiantes.edit', compact(
            'estudiante',
            'grados',
            'grado_actual',
            'direccion_partes',
            'adecuaciones',
            'adecuacion_actual'
        ));
    }

    /**
     * Actualiza los datos de un estudiante
     */
    public function update(EstudianteRequest $request, Estudiante $estudiante): RedirectResponse
    {
        $validated = $request->validated();

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
                'activo' => $request->has('activo'),
            ]);

            // Manejar cambio de grado
            if (!empty($validated['grado_id'])) {
                $grado_actual = $estudiante->grados()->first();

                // Solo actualizar si es diferente al actual
                if (!$grado_actual || $grado_actual->id != $validated['grado_id']) {
                    // Eliminar el grado actual
                    if ($grado_actual) {
                        $estudiante->grados()->detach($grado_actual->id);
                    }

                    // Asignar el nuevo grado
                    $estudiante->grados()->attach($validated['grado_id']);
                }
            }

            // Manejar adecuaciones
            $adecuacion_activa = $request->has('adecuacion_activa');

            if ($request->boolean('tiene_adecuacion') && !empty($validated['adecuacion_id'])) {
                // Verificar si ya tiene adecuaciones
                $adecuacion_existente = $estudiante->adecuaciones()->first();

                if ($adecuacion_existente) {
                    // Si tiene una adecuación diferente, la reemplazamos
                    if ($adecuacion_existente->id != $validated['adecuacion_id']) {
                        $estudiante->adecuaciones()->detach($adecuacion_existente->id);
                        $estudiante->adecuaciones()->attach($validated['adecuacion_id'], [
                            'nivel' => $validated['nivel_adecuacion'],
                            'fecha_asignacion' => $validated['fecha_asignacion_adecuacion'],
                            'activo' => $adecuacion_activa,
                        ]);
                    } else {
                        // Si es la misma adecuación, solo actualizamos los datos
                        $estudiante->adecuaciones()->updateExistingPivot($validated['adecuacion_id'], [
                            'nivel' => $validated['nivel_adecuacion'],
                            'fecha_asignacion' => $validated['fecha_asignacion_adecuacion'],
                            'activo' => $adecuacion_activa,
                        ]);
                    }
                } else {
                    // No tiene adecuación, agregamos una nueva
                    $estudiante->adecuaciones()->attach($validated['adecuacion_id'], [
                        'nivel' => $validated['nivel_adecuacion'],
                        'fecha_asignacion' => $validated['fecha_asignacion_adecuacion'],
                        'activo' => $adecuacion_activa,
                    ]);
                }
            } else {
                // Si desmarcó "tiene_adecuacion", eliminar todas las adecuaciones
                $estudiante->adecuaciones()->detach();
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
                'trace' => $e->getTraceAsString()
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
