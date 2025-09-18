<?php

use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\EstudianteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BitacoraController; // --- AÑADIR ESTA LÍNEA ---

// Ruta para la página principal (índice de módulos)
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/asistencia', [AttendanceController::class, 'index'])->name('attendance.index');
Route::get('/asistencia/crear', [AttendanceController::class, 'create'])->name('attendance.create');
Route::get('/estudiantes', [EstudianteController::class, 'index'])->name('estudiantes.index');
Route::get('/estudiantes/crear', [EstudianteController::class, 'create'])->name('estudiantes.create');
Route::get('/estudiantes/{id}', [EstudianteController::class, 'show'])->name('estudiantes.show');
Route::get('/profesores', [ProfesorController::class, 'index'])->name('profesores.index');
Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');

// --- NUEVA RUTA PARA BITÁCORA ---
Route::get('/bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');
// --- FIN DE NUEVA RUTA ---
