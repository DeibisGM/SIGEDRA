<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController; // ¡Muy importante importar el controlador!

// Ruta para la página principal (índice de módulos)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// routes/web.php
Route::get('/debug-key', function () {
    return env('APP_KEY');
});


// ESTA ES LA RUTA CRÍTICA
// Asegúrate de que llama a AttendanceController y no directamente a la vista.
Route::get('/asistencia', [AttendanceController::class, 'index'])->name('attendance.index');
