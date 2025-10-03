<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessExportJob;
use App\Models\Export;
use App\Services\Export\ExportManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    public function __construct(
        private ExportManager $exportManager
    ) {}

    /**
     * Muestra la lista de exportaciones del usuario
     */
    public function index()
    {
        $exports = Export::where('user_id', Auth::id())
            ->with('user')
            ->latest()
            ->paginate(15);

        $availableTypes = $this->exportManager->getAvailableTypes();
        $availableFormats = $this->exportManager->getAvailableFormats();

        return view('exports.index', compact('exports', 'availableTypes', 'availableFormats'));
    }

    /**
     * Crea una nueva exportación
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:estudiantes,maestros,grados',
            'format' => 'required|in:pdf,excel,csv',
            'filters' => 'nullable|array',
        ]);

        try {
            // Crear el registro de exportación
            $export = $this->exportManager->createExport(
                type: $request->type,
                format: $request->format,
                filters: $request->filters ?? []
            );

            // Procesar inmediatamente para tener el archivo listo
            $this->exportManager->processExport($export);

            return redirect()->back()->with('success', 'Exportación completada correctamente. Ya puedes descargar el archivo.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al procesar la exportación: ' . $e->getMessage());
        }
    }

    /**
     * Procesa una exportación de forma síncrona (para testing)
     */
    public function processSync(Request $request)
    {
        $request->validate([
            'type' => 'required|in:estudiantes,maestros,grados',
            'format' => 'required|in:pdf,excel,csv',
            'filters' => 'nullable|array',
        ]);

        try {
            // Crear el registro de exportación
            $export = $this->exportManager->createExport(
                type: $request->type,
                format: $request->format,
                filters: $request->filters ?? []
            );

            // Procesar inmediatamente
            $this->exportManager->processExport($export);

            return response()->json([
                'success' => true,
                'message' => 'Exportación completada correctamente.',
                'export_id' => $export->id,
                'download_url' => route('exports.download', $export)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la exportación: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Descarga un archivo de exportación
     */
    public function download(Export $export)
    {
        try {
            // Verificar que el usuario puede descargar esta exportación
            if ($export->user_id !== Auth::id()) {
                abort(403, 'No tienes permisos para descargar esta exportación.');
            }

            return $this->exportManager->downloadExport($export);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al descargar el archivo: ' . $e->getMessage());
        }
    }

    /**
     * Muestra el estado de una exportación
     */
    public function status(Export $export)
    {
        // Verificar que el usuario puede ver esta exportación
        if ($export->user_id !== Auth::id()) {
            abort(403);
        }

        return response()->json([
            'id' => $export->id,
            'status' => $export->status,
            'progress' => $this->getProgressPercentage($export),
            'message' => $this->getStatusMessage($export),
            'download_url' => $export->status === Export::STATUS_COMPLETED 
                ? route('exports.download', $export) 
                : null,
            'created_at' => $export->created_at->format('d/m/Y H:i:s'),
            'completed_at' => $export->completed_at?->format('d/m/Y H:i:s'),
            'file_size' => $export->formatted_file_size,
            'records_count' => $export->records_count,
            'error_message' => $export->error_message,
        ]);
    }

    /**
     * Elimina una exportación
     */
    public function destroy(Export $export)
    {
        // Verificar que el usuario puede eliminar esta exportación
        if ($export->user_id !== Auth::id()) {
            abort(403);
        }

        try {
            // Eliminar archivo si existe
            if ($export->file_path && \Storage::disk('local')->exists($export->file_path)) {
                \Storage::disk('local')->delete($export->file_path);
            }

            $export->delete();

            return response()->json([
                'success' => true,
                'message' => 'Exportación eliminada correctamente.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la exportación: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene el porcentaje de progreso
     */
    private function getProgressPercentage(Export $export): int
    {
        return match($export->status) {
            Export::STATUS_PENDING => 0,
            Export::STATUS_PROCESSING => 50,
            Export::STATUS_COMPLETED => 100,
            Export::STATUS_FAILED => 0,
            default => 0,
        };
    }

    /**
     * Obtiene el mensaje de estado
     */
    private function getStatusMessage(Export $export): string
    {
        return match($export->status) {
            Export::STATUS_PENDING => 'En cola de procesamiento...',
            Export::STATUS_PROCESSING => 'Procesando exportación...',
            Export::STATUS_COMPLETED => 'Exportación completada',
            Export::STATUS_FAILED => 'Error en la exportación: ' . $export->error_message,
            default => 'Estado desconocido',
        };
    }
}
