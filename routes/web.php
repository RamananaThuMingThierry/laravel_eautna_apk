<?php

use App\Http\Controllers\AxesController;
use App\Http\Controllers\WEB\AxesController as WEBAxesController;
use App\Http\Controllers\WEB\FilieresController;
use App\Http\Controllers\WEB\FonctionsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.admin');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('axes', WEBAxesController::class);
    Route::resource('filieres', FilieresController::class);
    Route::resource('fonctions', FonctionsController::class);
});
