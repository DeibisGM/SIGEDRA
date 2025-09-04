<?php

use Illuminate\Support\Facades\Route;

// Ruta para la página principal (índice de módulos)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Ruta para el módulo de asistencia
Route::get('/asistencia', function() {
    return view('attendance.index');
})->name('attendance.index');
