<?php

namespace App\Console\Commands;

use App\Services\Export\ExportManager;
use Illuminate\Console\Command;

class CleanupExportsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:cleanup {--days=30 : Días de antigüedad para eliminar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpia archivos de exportación antiguos del sistema';

    /**
     * Execute the console command.
     */
    public function handle(ExportManager $exportManager): int
    {
        $days = (int) $this->option('days');
        
        $this->info("Iniciando limpieza de exportaciones con más de {$days} días...");
        
        try {
            $deletedCount = $exportManager->cleanupOldExports($days);
            
            if ($deletedCount > 0) {
                $this->info("✅ Se eliminaron {$deletedCount} exportaciones antiguas.");
            } else {
                $this->info("ℹ️  No se encontraron exportaciones para eliminar.");
            }
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->error("❌ Error durante la limpieza: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
