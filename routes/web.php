<?php

//esto trae las herramientas que se van a usar
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PanelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareaController;

//Solo para quien no ha iniciado sesión
Route::middleware('guest')->group(function(){
    Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
    ->name('login.enviar')
    ->middleware('throttle:5,1'); //maximo 5 intentos en un minuto

    Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro');
    Route::post('/registro', [AuthController::class, 'registro'])->name('registro.enviar');
});

//Solo para quien si ha iniciado sesión
Route::middleware('auth')->group(function(){
    Route::get('/', [PanelController::class, 'index'])->name('panel');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/tareas', [TareaController::class, 'index']);
    Route::post('/tareas', [TareaController::class, 'store']);
    Route::put('/tareas/{id}', [TareaController::class, 'update']);
    Route::patch('/tareas/{id}/estado', [TareaController::class, 'actualizarEstado']);
    Route::delete('/tareas/{id}', [TareaController::class, 'destroy']);
});