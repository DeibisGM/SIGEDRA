<?php

namespace App\Jobs;

use App\Models\Export;
use App\Services\Export\ExportManager;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessExportJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public int $timeout = 300; // 5 minutos
    public int $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Export $export
    ) {
        // Configurar la cola si es necesario
        $this->onQueue('exports');
    }

    /**
     * Execute the job.
     */
    public function handle(ExportManager $exportManager): void
    {
        try {
            Log::info("Iniciando procesamiento de exportación ID: {$this->export->id}");
            
            $exportManager->processExport($this->export);
            
            Log::info("Exportación completada exitosamente ID: {$this->export->id}");
            
        } catch (\Exception $e) {
            Log::error("Error procesando exportación ID: {$this->export->id}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e; // Re-lanzar para que Laravel pueda manejar los reintentos
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("Falló definitivamente la exportación ID: {$this->export->id}", [
            'error' => $exception->getMessage()
        ]);

        // Marcar la exportación como fallida si no se hizo ya
        if ($this->export->status !== Export::STATUS_FAILED) {
            $this->export->markAsFailed($exception->getMessage());
        }
    }
}
