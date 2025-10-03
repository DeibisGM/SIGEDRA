<?php

namespace App\Services\Export;

interface ExportServiceInterface
{
    /**
     * Obtiene los datos para exportar
     */
    public function getData(array $filters = []): \Illuminate\Database\Eloquent\Collection;

    /**
     * Obtiene los encabezados de la tabla
     */
    public function getHeaders(): array;

    /**
     * Formatea una fila de datos para la exportación
     */
    public function formatRow($item): array;

    /**
     * Obtiene el nombre del archivo por defecto
     */
    public function getDefaultFileName(string $format): string;

    /**
     * Obtiene el tipo de exportación
     */
    public function getType(): string;
}