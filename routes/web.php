<?php

use App\Http\Controllers\ActivoController;
use Illuminate\Support\Facades\Route;

// Redirección desde la raíz al index
Route::get('/', fn() => redirect()->route('activos.index'));

// Ruta RESTful completa para ActivoController
Route::resource('activos', ActivoController::class);


