<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\AxesController;
use App\Http\Controllers\WEB\UserController;
use App\Http\Controllers\WEB\LoginController;
use App\Http\Controllers\WEB\NiveauController;
use App\Http\Controllers\WEB\MembresController;
use App\Http\Controllers\WEB\FilieresController;
use App\Http\Controllers\WEB\RegisterController;
use App\Http\Controllers\WEB\FonctionsController;
use App\Http\Controllers\WEB\ResetPasswordController;
use App\Http\Controllers\WEB\ForgetPasswordController;

Route::get('/', [LoginController::class, 'login'])->name('login');
Route::get('/inscription', [RegisterController::class, 'showRegistrationForm'])->name('inscription');
Route::post('/inscription', [RegisterController::class, 'register'])->name('register.post');

Route::get('/mot-de-passe-oublie', [ForgetPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::get('reset-password', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('utilisateurs', UserController::class);
    Route::resource('axes', AxesController::class);
    Route::resource('filieres', FilieresController::class);
    Route::resource('fonctions', FonctionsController::class);
    Route::resource('niveaux', NiveauController::class);
    Route::resource('membres', MembresController::class);
});
