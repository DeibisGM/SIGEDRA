<?php

namespace App\Http\Controllers;

use App\Models\CargaAcademica;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(): View
    {
        return view('attendance.index');
    }

    public function create(Request $request): View
    {
        // Se espera que la vista 'create' llame a un componente Livewire
        // que se encargue de la lógica de toma de asistencia.
        // Aquí solo pasamos los parámetros necesarios para inicializarlo.
        return view('attendance.create', [
            'carga_academica_id' => $request->query('carga_academica_id'),
            'fecha' => $request->query('fecha'),
        ]);
    }
}
