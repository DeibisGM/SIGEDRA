<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\EstudianteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BitacoraController;

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home'); // Redirect to dashboard if authenticated
    }
    return redirect()->route('login'); // Redirect to login if not authenticated
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Existing Routes
    Route::get('/asistencia', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/asistencia/crear', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::get('/estudiantes', [EstudianteController::class, 'index'])->name('estudiantes.index');
    Route::get('/estudiantes/crear', [EstudianteController::class, 'create'])->name('estudiantes.create');
    Route::get('/estudiantes/{id}', [EstudianteController::class, 'show'])->name('estudiantes.show');

    // Profesor routes
    Route::resource('profesores', ProfesorController::class)->only(['index', 'show']);

    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');
});


require __DIR__.'/auth.php';
