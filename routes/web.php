<?php

use Illuminate\Support\Facades\Route;

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
    Route::get('/', function() {
        return view('pages.especialidades');
    })->name('especialidades.cadastrar');
});

Route::prefix('medicos')->group(function () {

});

Route::prefix('medicos_especialidades')->group(function () {

});
