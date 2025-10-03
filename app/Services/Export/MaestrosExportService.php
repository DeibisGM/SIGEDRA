<?php

namespace App\Services\Export;

use App\Models\Maestro;
use Illuminate\Database\Eloquent\Collection;

class MaestrosExportService implements ExportServiceInterface
{
    public function getData(array $filters = []): Collection
    {
        $query = Maestro::query()
            ->with(['user', 'cargasAcademicas.grado.nivelAcademico', 'cargasAcademicas.materia']);

        // Aplicar filtros
        if (!empty($filters['activo'])) {
            $query->where('activo', $filters['activo']);
        }

        if (!empty($filters['nacionalidad'])) {
            $query->where('nacionalidad', $filters['nacionalidad']);
        }

        if (!empty($filters['fecha_nombramiento_desde'])) {
            $query->where('nombramiento_inicio', '>=', $filters['fecha_nombramiento_desde']);
        }

        if (!empty($filters['fecha_nombramiento_hasta'])) {
            $query->where('nombramiento_inicio', '<=', $filters['fecha_nombramiento_hasta']);
        }

        if (!empty($filters['tiene_carga_academica'])) {
            if ($filters['tiene_carga_academica'] === 'si') {
                $query->has('cargasAcademicas');
            } else {
                $query->doesntHave('cargasAcademicas');
            }
        }

        if (!empty($filters['buscar'])) {
            $query->where(function($q) use ($filters) {
                $q->where('primer_nombre', 'like', "%{$filters['buscar']}%")
                  ->orWhere('segundo_nombre', 'like', "%{$filters['buscar']}%")
                  ->orWhere('primer_apellido', 'like', "%{$filters['buscar']}%")
                  ->orWhere('segundo_apellido', 'like', "%{$filters['buscar']}%")
                  ->orWhere('correo', 'like', "%{$filters['buscar']}%");
            });
        }

        return $query->orderBy('primer_apellido')->orderBy('primer_nombre')->get();
    }

    public function getHeaders(): array
    {
        return [
            'ID Usuario',
            'Nombre Completo',
            'Primer Nombre',
            'Segundo Nombre',
            'Primer Apellido',
            'Segundo Apellido',
            'Teléfono',
            'Correo',
            'Nacionalidad',
            'Fecha Nombramiento Inicio',
            'Fecha Nombramiento Final',
            'Días de Nombramiento',
            'Cargas Académicas',
            'Grados que Enseña',
            'Materias que Enseña',
            'Estado'
        ];
    }

    public function formatRow($maestro): array
    {
        $cargasAcademicas = $maestro->cargasAcademicas;
        $grados = $cargasAcademicas->pluck('grado.nivelAcademico.nombre')->filter()->unique()->join(', ');
        $materias = $cargasAcademicas->pluck('materia.nombre')->filter()->unique()->join(', ');
        
        $diasNombramiento = '';
        if ($maestro->nombramiento_inicio) {
            $fechaFin = $maestro->nombramiento_final ?? now();
            $diasNombramiento = $maestro->nombramiento_inicio->diffInDays($fechaFin);
        }

        return [
            $maestro->usuario_id ?? 'Sin usuario',
            $maestro->nombre_completo,
            $maestro->primer_nombre,
            $maestro->segundo_nombre ?? '',
            $maestro->primer_apellido,
            $maestro->segundo_apellido ?? '',
            $maestro->telefono ?? '',
            $maestro->correo ?? '',
            $maestro->nacionalidad ?? '',
            $maestro->nombramiento_inicio ? $maestro->nombramiento_inicio->format('d/m/Y') : '',
            $maestro->nombramiento_final ? $maestro->nombramiento_final->format('d/m/Y') : 'Vigente',
            $diasNombramiento,
            $cargasAcademicas->count(),
            $grados ?: 'Ninguno',
            $materias ?: 'Ninguna',
            $maestro->activo ? 'Activo' : 'Inactivo'
        ];
    }

    public function getDefaultFileName(string $format): string
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        $extension = $format === 'excel' ? 'xlsx' : $format;
        return "maestros_export_{$timestamp}.{$extension}";
    }

    public function getType(): string
    {
        return 'maestros';
    }
}