<?php

namespace App\Services\Export;

use App\Models\Export;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ExportManager
{
    private array $exporters = [
        'estudiantes' => EstudiantesExportService::class,
        'maestros' => MaestrosExportService::class,
        'grados' => GradosExportService::class,
    ];

    /**
     * Inicia una nueva exportación
     */
    public function createExport(string $type, string $format, array $filters = [], ?User $user = null): Export
    {
        if (!isset($this->exporters[$type])) {
            throw new \InvalidArgumentException("Tipo de exportación no válido: {$type}");
        }

        if (!in_array($format, ['pdf', 'excel', 'csv'])) {
            throw new \InvalidArgumentException("Formato no válido: {$format}");
        }

        return Export::create([
            'user_id' => $user?->id ?? auth()->id(),
            'type' => $type,
            'format' => $format,
            'status' => Export::STATUS_PENDING,
            'filters' => $filters,
        ]);
    }

    /**
     * Procesa una exportación
     */
    public function processExport(Export $export): void
    {
        try {
            $export->markAsProcessing();

            $exporter = $this->getExporter($export->type);
            $data = $exporter->getData($export->filters ?? []);

            if ($data->isEmpty()) {
                throw new \Exception('No se encontraron datos para exportar con los filtros aplicados.');
            }

            $fileName = $exporter->getDefaultFileName($export->format);
            $filePath = $this->generateFile($exporter, $data, $export->format, $fileName);
            $fileSize = Storage::disk('local')->size($filePath);

            $export->markAsCompleted($fileName, $filePath, $fileSize, $data->count());

        } catch (\Exception $e) {
            $export->markAsFailed($e->getMessage());
            throw $e;
        }
    }

    /**
     * Genera el archivo de exportación
     */
    private function generateFile(ExportServiceInterface $exporter, $data, string $format, string $fileName): string
    {
        $filePath = "exports/{$fileName}";

        switch ($format) {
            case 'csv':
                $this->generateCsvFile($exporter, $data, $filePath);
                break;
            case 'excel':
                $this->generateExcelFile($exporter, $data, $filePath);
                break;
            case 'pdf':
                $this->generatePdfFile($exporter, $data, $filePath);
                break;
            default:
                throw new \InvalidArgumentException("Formato no soportado: {$format}");
        }

        return $filePath;
    }

    /**
     * Genera archivo CSV (alternativa simple a Excel)
     */
    private function generateCsvFile(ExportServiceInterface $exporter, $data, string $filePath): void
    {
        $localPath = Storage::disk('local')->path($filePath);
        
        // Crear directorio si no existe
        $directory = dirname($localPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $file = fopen($localPath, 'w');
        
        // Escribir BOM para UTF-8 (para compatibilidad con Excel)
        fwrite($file, "\xEF\xBB\xBF");
        
        // Escribir encabezados
        fputcsv($file, $exporter->getHeaders(), ';');
        
        // Escribir datos
        foreach ($data as $item) {
            fputcsv($file, $exporter->formatRow($item), ';');
        }
        
        fclose($file);
    }

    /**
     * Genera archivo Excel (requiere phpoffice/phpspreadsheet)
     */
    private function generateExcelFile(ExportServiceInterface $exporter, $data, string $filePath): void
    {
        if (!class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet')) {
            throw new \Exception('PhpSpreadsheet no está instalado. Use formato CSV como alternativa.');
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Configurar encabezados
        $headers = $exporter->getHeaders();
        $sheet->fromArray($headers, null, 'A1');

        // Estilo para encabezados
        $headerRange = 'A1:' . chr(64 + count($headers)) . '1';
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('E2E8F0');

        // Agregar datos
        $row = 2;
        foreach ($data as $item) {
            $formattedRow = $exporter->formatRow($item);
            $sheet->fromArray($formattedRow, null, "A{$row}");
            $row++;
        }

        // Autoajustar columnas
        foreach (range('A', chr(64 + count($headers))) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Guardar archivo
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $localPath = Storage::disk('local')->path($filePath);
        
        // Crear directorio si no existe
        $directory = dirname($localPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $writer->save($localPath);
    }

    /**
     * Genera archivo PDF (requiere barryvdh/laravel-dompdf)
     */
    private function generatePdfFile(ExportServiceInterface $exporter, $data, string $filePath): void
    {
        if (!class_exists('Barryvdh\DomPDF\Facade\Pdf')) {
            throw new \Exception('DomPDF no está instalado. Use formato CSV como alternativa.');
        }

        $headers = $exporter->getHeaders();
        $rows = [];

        foreach ($data as $item) {
            $rows[] = $exporter->formatRow($item);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.pdf-template', [
            'title' => ucfirst($exporter->getType()),
            'headers' => $headers,
            'data' => $rows,
            'totalRecords' => count($rows),
            'generatedAt' => now()->format('d/m/Y H:i:s'),
        ]);

        $pdf->setPaper('a4', 'landscape');
        
        $localPath = Storage::disk('local')->path($filePath);
        
        // Crear directorio si no existe
        $directory = dirname($localPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $pdf->save($localPath);
    }

    /**
     * Descarga un archivo de exportación
     */
    public function downloadExport(Export $export)
    {
        if ($export->status !== Export::STATUS_COMPLETED || !$export->file_path) {
            throw new \Exception('La exportación no está disponible para descarga.');
        }

        if (!Storage::disk('local')->exists($export->file_path)) {
            throw new \Exception('El archivo de exportación no existe.');
        }

        return Storage::disk('local')->download($export->file_path, $export->file_name);
    }

    /**
     * Elimina archivos antiguos de exportación
     */
    public function cleanupOldExports(int $daysOld = 30): int
    {
        $cutoffDate = now()->subDays($daysOld);
        $oldExports = Export::where('created_at', '<', $cutoffDate)
            ->where('status', Export::STATUS_COMPLETED)
            ->get();

        $deletedCount = 0;

        foreach ($oldExports as $export) {
            if ($export->file_path && Storage::disk('local')->exists($export->file_path)) {
                Storage::disk('local')->delete($export->file_path);
            }
            $export->delete();
            $deletedCount++;
        }

        return $deletedCount;
    }

    /**
     * Obtiene una instancia del exportador
     */
    private function getExporter(string $type): ExportServiceInterface
    {
        $exporterClass = $this->exporters[$type];
        return new $exporterClass();
    }

    /**
     * Obtiene los tipos de exportación disponibles
     */
    public function getAvailableTypes(): array
    {
        return array_keys($this->exporters);
    }

    /**
     * Obtiene los formatos disponibles
     */
    public function getAvailableFormats(): array
    {
        $formats = ['csv']; // CSV siempre disponible
        
        if (class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet')) {
            $formats[] = 'excel';
        }
        
        if (class_exists('Barryvdh\DomPDF\Facade\Pdf')) {
            $formats[] = 'pdf';
        }
        
        return $formats;
    }
}