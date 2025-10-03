<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Export extends Model
{
    use HasFactory;

    protected $table = 'exports';

    protected $fillable = [
        'user_id',
        'type', // 'estudiantes', 'maestros', 'grados'
        'format', // 'pdf', 'excel'
        'status', // 'pending', 'processing', 'completed', 'failed'
        'file_name',
        'file_path',
        'file_size',
        'records_count',
        'filters', // JSON con filtros aplicados
        'error_message',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'filters' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relaciones
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', Carbon::now()->subDays($days));
    }

    // Métodos de estado
    public function markAsProcessing()
    {
        $this->update([
            'status' => 'processing',
            'started_at' => now(),
        ]);
    }

    public function markAsCompleted($fileName, $filePath, $fileSize, $recordsCount)
    {
        $this->update([
            'status' => 'completed',
            'file_name' => $fileName,
            'file_path' => $filePath,
            'file_size' => $fileSize,
            'records_count' => $recordsCount,
            'completed_at' => now(),
        ]);
    }

    public function markAsFailed($errorMessage)
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage,
            'completed_at' => now(),
        ]);
    }

    // Getters útiles
    public function getFormattedFileSizeAttribute()
    {
        if (!$this->file_size) return null;
        
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = $this->file_size;
        $i = 0;
        
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getDurationAttribute()
    {
        if (!$this->started_at || !$this->completed_at) return null;
        
        return $this->started_at->diffForHumans($this->completed_at, true);
    }

    // Constantes para tipos y estados
    const TYPE_ESTUDIANTES = 'estudiantes';
    const TYPE_MAESTROS = 'maestros';
    const TYPE_GRADOS = 'grados';

    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';

    const FORMAT_PDF = 'pdf';
    const FORMAT_EXCEL = 'excel';
    const FORMAT_CSV = 'csv';
}

