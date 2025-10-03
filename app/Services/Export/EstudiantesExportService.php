<?php

namespace App\Services\Export;

use App\Models\Estudiante;
use Illuminate\Database\Eloquent\Collection;

class EstudiantesExportService implements ExportServiceInterface
{
    public function getData(array $filters = []): Collection
    {
        $query = Estudiante::query()
            ->with(['grados.nivelAcademico', 'grados.anioAcademico']);

        // Aplicar filtros
        if (!empty($filters['activo'])) {
            $query->where('activo', $filters['activo']);
        }

        if (!empty($filters['grado_id'])) {
            $query->whereHas('grados', function($q) use ($filters) {
                $q->where('grado_id', $filters['grado_id']);
            });
        }

        if (!empty($filters['genero'])) {
            $query->where('genero', $filters['genero']);
        }

        if (!empty($filters['nacionalidad'])) {
            $query->where('nacionalidad', $filters['nacionalidad']);
        }

        if (!empty($filters['edad_min']) || !empty($filters['edad_max'])) {
            // Filtro por rango de edad (requiere cálculo)
            $query->whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) >= ?', [$filters['edad_min'] ?? 0]);
            if (!empty($filters['edad_max'])) {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) <= ?', [$filters['edad_max']]);
            }
        }

        if (!empty($filters['buscar'])) {
            $query->buscar($filters['buscar']);
        }

        return $query->orderBy('primer_apellido')->orderBy('primer_nombre')->get();
    }

    public function getHeaders(): array
    {
        return [
            'Cédula',
            'Nombre Completo',
            'Primer Nombre',
            'Segundo Nombre',
            'Primer Apellido',
            'Segundo Apellido',
            'Fecha Nacimiento',
            'Edad',
            'Género',
            'Nacionalidad',
            'Dirección',
            'Grado Actual',
            'Nivel Académico',
            'Año Académico',
            'Estado'
        ];
    }

    public function formatRow($estudiante): array
    {
        $gradoActual = $estudiante->grados->first();
        
        return [
            $estudiante->cedula,
            $estudiante->nombre_completo,
            $estudiante->primer_nombre,
            $estudiante->segundo_nombre ?? '',
            $estudiante->primer_apellido,
            $estudiante->segundo_apellido ?? '',
            $estudiante->fecha_nacimiento->format('d/m/Y'),
            $estudiante->edad,
            ucfirst($estudiante->genero),
            $estudiante->nacionalidad,
            $estudiante->direccion ?? '',
            $gradoActual ? $gradoActual->nivelAcademico->nombre ?? 'N/A' : 'Sin asignar',
            $gradoActual ? $gradoActual->nivelAcademico->descripcion ?? 'N/A' : 'Sin asignar',
            $gradoActual ? $gradoActual->anioAcademico->nombre ?? 'N/A' : 'Sin asignar',
            $estudiante->activo ? 'Activo' : 'Inactivo'
        ];
    }

    public function getDefaultFileName(string $format): string
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        $extension = $format === 'excel' ? 'xlsx' : $format;
        return "estudiantes_export_{$timestamp}.{$extension}";
    }

    public function getType(): string
    {
        return 'estudiantes';
    }
}