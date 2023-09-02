<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EspecialidadeController;

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
    return view('pages.home');
});


Route::prefix('especialidades')->group(function () {
    Route::get('/', [EspecialidadeController::class, 'index'])->name('especialidades.list');
    Route::get('/lista', [EspecialidadeController::class, 'index']);
    Route::post('/create', [EspecialidadeController::class, 'create'])->name('especialidades.create');
    Route::post('/read', [EspecialidadeController::class, 'read']);

});

// Route::prefix('medicos')->group(function () {
//     Route::get('/', function() {
//         return view('pages.medicos');
//     })->name('medicos.cadastrar');
// });

// Route::prefix('medicos_especialidades')->group(function () {

// });
