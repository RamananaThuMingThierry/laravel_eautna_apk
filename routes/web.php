<?php

use App\Http\Controllers\AxesController;
use App\Http\Controllers\WEB\FilieresController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.admin');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('filieres', FilieresController::class);
});
