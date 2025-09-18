<?php

use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\EstudianteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController; // ¡Muy importante importar el controlador!

// Ruta para la página principal (índice de módulos)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ESTA ES LA RUTA CRÍTICA
// Asegúrate de que llama a AttendanceController y no directamente a la vista.
Route::get('/asistencia', [AttendanceController::class, 'index'])->name('attendance.index');
Route::get('/asistencia/crear', [AttendanceController::class, 'create'])->name('attendance.create');
Route::get('/estudiantes', [EstudianteController::class, 'index'])->name('estudiantes.index');
Route::get('/estudiantes/crear', [EstudianteController::class, 'create'])->name('estudiantes.create');
Route::get('/profesores', [ProfesorController::class, 'index'])->name('profesores.index');
Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');

