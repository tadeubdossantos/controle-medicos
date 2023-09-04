<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EspecialidadeController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\MedicoEspecialidadeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $especialidade = new EspecialidadeController();
    $qtdEspecialidades = $especialidade->countRows();
    $medicos = new MedicoController();
    $qtdMedicos = $medicos->countRows();
    return view('pages.inicio', compact('qtdEspecialidades', 'qtdMedicos'));
});

Route::prefix('especialidades')->group(function () {
    Route::get('/', [EspecialidadeController::class, 'index'])->name('especialidades.list');
    Route::post('/lista', [EspecialidadeController::class, 'index']);
    Route::post('/cadastrar', [EspecialidadeController::class, 'create'])->name('especialidades.create');
    Route::post('/consultar', [EspecialidadeController::class, 'read']);
    Route::post('/alterar', [EspecialidadeController::class, 'update']);
    Route::post('/excluir', [EspecialidadeController::class, 'delete']);
});

Route::prefix('medicos')->group(function () {
    Route::get('/', [MedicoController::class, 'index'])->name('medicos.list');
    Route::post('/lista', [MedicoController::class, 'index']);
    Route::post('/cadastrar', [MedicoController::class, 'create'])->name('medicos.create');
    Route::post('/consultar', [MedicoController::class, 'read']);
    Route::post('/alterar', [MedicoController::class, 'alterar']);
    Route::post('/excluir', [MedicoController::class, 'delete']);
});

Route::prefix('relatorio')->group(function () {
    Route::get('/', [MedicoEspecialidadeController::class, 'index'])->name('relatorio.list');
    Route::post('/', [MedicoEspecialidadeController::class, 'relatorio']);
});

