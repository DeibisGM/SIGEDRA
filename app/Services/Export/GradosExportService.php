<?php

namespace App\Services\Export;

use App\Models\Grado;
use Illuminate\Database\Eloquent\Collection;

class GradosExportService implements ExportServiceInterface
{
    public function getData(array $filters = []): Collection
    {
        $query = Grado::query()
            ->with([
                'nivelAcademico',
                'anioAcademico',
                'estudiantes' => function($q) {
                    $q->where('activo', true);
                }
            ]);

        // Aplicar filtros
        if (!empty($filters['activo'])) {
            $query->where('activo', $filters['activo']);
        }

        if (!empty($filters['nivel_academico_id'])) {
            $query->where('nivel_academico_id', $filters['nivel_academico_id']);
        }

        if (!empty($filters['anio_academico_id'])) {
            $query->where('anio_lectivo_id', $filters['anio_academico_id']);
        }

        if (!empty($filters['estudiantes_min'])) {
            $query->has('estudiantes', '>=', $filters['estudiantes_min']);
        }

        if (!empty($filters['estudiantes_max'])) {
            $query->has('estudiantes', '<=', $filters['estudiantes_max']);
        }

        return $query->orderBy('nivel_academico_id')->get();
    }

    public function getHeaders(): array
    {
        return [
            'ID Grado',
            'Nivel Académico',
            'Descripción Nivel',
            'Año Académico',
            'Fecha Inicio Año',
            'Fecha Fin Año',
            'Total Estudiantes',
            'Estudiantes Activos',
            'Estudiantes Masculinos',
            'Estudiantes Femeninos',
            'Promedio Edad Estudiantes',
            'Estudiante Más Joven',
            'Estudiante Mayor',
            'Estado Grado'
        ];
    }

    public function formatRow($grado): array
    {
        $estudiantes = $grado->estudiantes;
        $estudiantesActivos = $estudiantes->where('activo', true);
        
        $masculinos = $estudiantesActivos->where('genero', 'masculino')->count();
        $femeninos = $estudiantesActivos->where('genero', 'femenino')->count();
        
        $edades = $estudiantesActivos->pluck('edad')->filter();
        $promedioEdad = $edades->count() > 0 ? round($edades->avg(), 1) : 0;
        $edadMenor = $edades->count() > 0 ? $edades->min() : 0;
        $edadMayor = $edades->count() > 0 ? $edades->max() : 0;

        return [
            $grado->id,
            $grado->nivelAcademico->nombre ?? 'N/A',
            $grado->nivelAcademico->descripcion ?? 'N/A',
            $grado->anioAcademico->nombre ?? 'N/A',
            $grado->anioAcademico->fecha_inicio ? $grado->anioAcademico->fecha_inicio->format('d/m/Y') : 'N/A',
            $grado->anioAcademico->fecha_fin ? $grado->anioAcademico->fecha_fin->format('d/m/Y') : 'N/A',
            $estudiantes->count(),
            $estudiantesActivos->count(),
            $masculinos,
            $femeninos,
            $promedioEdad . ' años',
            $edadMenor . ' años',
            $edadMayor . ' años',
            $grado->activo ? 'Activo' : 'Inactivo'
        ];
    }

    public function getDefaultFileName(string $format): string
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        $extension = $format === 'excel' ? 'xlsx' : $format;
        return "grados_export_{$timestamp}.{$extension}";
    }

    public function getType(): string
    {
        return 'grados';
    }
}