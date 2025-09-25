<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class BitacoraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Datos quemados para la bitácora
        $logs = [
            [
                'timestamp' => Carbon::now()->subHours(2)->format('Y-m-d h:i:s A'),
                'activity' => 'Edición de Perfil',
                'icon' => 'ph-user-circle-gear',
                'color' => 'text-blue-500',
                'user' => 'Nancy T.',
                'user_avatar_initials' => 'NT',
                'details' => 'Actualizó la foto de perfil y la información de contacto.'
            ],
            [
                'timestamp' => Carbon::now()->subHours(5)->format('Y-m-d h:i:s A'),
                'activity' => 'Carga de Archivo',
                'icon' => 'ph-upload-simple',
                'color' => 'text-purple-500',
                'user' => 'Nancy T.',
                'user_avatar_initials' => 'NT',
                'details' => 'Subió el archivo "plan_de_estudios_2024.pdf" al módulo de Documentos.'
            ],
            [
                'timestamp' => Carbon::now()->subDay()->addHours(3)->format('Y-m-d h:i:s A'),
                'activity' => 'Creación de Estudiante',
                'icon' => 'ph-user-plus',
                'color' => 'text-green-500',
                'user' => 'Deibis Gutierrez',
                'user_avatar_initials' => 'DG',
                'details' => 'Creó un nuevo estudiante: "Ana Rojas" (Cédula: 2-0987-6543).'
            ],
            [
                'timestamp' => Carbon::now()->subDay()->addHours(2)->addMinutes(15)->format('Y-m-d h:i:s A'),
                'activity' => 'Acceso al Dashboard',
                'icon' => 'ph-squares-four',
                'color' => 'text-gray-500',
                'user' => 'Deibis Gutierrez',
                'user_avatar_initials' => 'DG',
                'details' => 'Accedió al dashboard principal del sistema.'
            ],
            [
                'timestamp' => Carbon::now()->subDay()->addHours(2)->addMinutes(14)->format('Y-m-d h:i:s A'),
                'activity' => 'Inicio de Sesión',
                'icon' => 'ph-sign-in',
                'color' => 'text-green-600',
                'user' => 'Deibis Gutierrez',
                'user_avatar_initials' => 'DG',
                'details' => 'Inicio de sesión exitoso desde red local.'
            ],
        ];

        return view('bitacora.index', ['logs' => $logs]);
    }
}
