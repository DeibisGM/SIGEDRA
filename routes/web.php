<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MaestroController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\EstudianteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BitacoraController;

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard'); // Redirect to dashboard if authenticated
    }
    return redirect()->route('login'); // Redirect to login if not authenticated
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Perfil de Usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Módulos Principales
    Route::get('/asistencia', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/asistencia/crear', [AttendanceController::class, 'create'])->name('attendance.create');

    // Rutas para Estudiantes (definidas manualmente para mayor claridad)
    // Rutas para Estudiantes
    Route::get('estudiantes', [EstudianteController::class, 'index'])->name('estudiantes.index');
    Route::get('estudiantes/create', [EstudianteController::class, 'create'])->name('estudiantes.create');
    Route::post('estudiantes', [EstudianteController::class, 'store'])->name('estudiantes.store');
    Route::get('estudiantes/{estudiante}', [EstudianteController::class, 'show'])->name('estudiantes.show');
    Route::get('estudiantes/{estudiante}/edit', [EstudianteController::class, 'edit'])->name('estudiantes.edit');
    Route::put('estudiantes/{estudiante}', [EstudianteController::class, 'update'])->name('estudiantes.update');
    Route::delete('estudiantes/{estudiante}', [EstudianteController::class, 'destroy'])->name('estudiantes.destroy');

    //Maestro
    Route::resource('maestros', MaestroController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');
});


require __DIR__.'/auth.php';
