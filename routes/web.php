<?php

use App\Http\Controllers\AxesController;
use App\Http\Controllers\WEB\AxesController as WEBAxesController;
use App\Http\Controllers\WEB\FilieresController;
use App\Http\Controllers\WEB\FonctionsController;
use App\Http\Controllers\WEB\MembresController;
use App\Http\Controllers\WEB\NiveauController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.admin');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('axes', WEBAxesController::class);
    Route::resource('filieres', FilieresController::class);
    Route::resource('fonctions', FonctionsController::class);
    Route::resource('niveaux', NiveauController::class);
    Route::resource('membres', MembresController::class);
});
