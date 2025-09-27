<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class BitacoraController extends Controller
{
    /**
     * Muestra una lista de registros de la bitácora.
     */
    public function index(): View
    {
        // En una implementación real, esto vendría de una tabla 'logs' o similar.
        // Por ahora, usamos datos de ejemplo para mantener la funcionalidad visual.
        $logs = [
            [
                'timestamp' => now()->subHours(2)->format('Y-m-d H:i:s'),
                'activity' => 'Edición de Perfil',
                'icon' => 'ph-user-circle-gear',
                'color' => 'text-blue-500',
                'user' => 'Nancy T.',
                'details' => 'Actualizó la foto de perfil.'
            ],
            [
                'timestamp' => now()->subDay()->format('Y-m-d H:i:s'),
                'activity' => 'Creación de Estudiante',
                'icon' => 'ph-user-plus',
                'color' => 'text-green-500',
                'user' => 'Deibis Gutierrez',
                'details' => 'Creó al estudiante "Ana Rojas".'
            ],
            [
                'timestamp' => now()->subDay()->addHours(2)->format('Y-m-d H:i:s'),
                'activity' => 'Inicio de Sesión',
                'icon' => 'ph-sign-in',
                'color' => 'text-green-600',
                'user' => 'Deibis Gutierrez',
                'details' => 'Inicio de sesión exitoso.'
            ],
        ];

        return view('bitacora.index', ['logs' => $logs]);
    }
}
