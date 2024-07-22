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
use App\Http\Controllers\WEB\ProfileController;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/inscription', [RegisterController::class, 'showRegistrationForm'])->name('inscription');
    Route::post('/inscription', [RegisterController::class, 'register'])->name('inscription.post');
    Route::get('/mot-de-passe-oublie', [ForgetPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::get('/reset-password', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('/utilisateur-en-attente', [UserController::class, 'waiting'])->name('status.not.approuved');
    Route::post('/se-deconnecter', [UserController::class, 'logout'])->name('logout');
});

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/profile',[ProfileController::class, 'index'])->name('profile');
    Route::resource('utilisateurs', UserController::class);
    Route::resource('axes', AxesController::class);
    Route::resource('filieres', FilieresController::class);
    Route::resource('fonctions', FonctionsController::class);
    Route::resource('niveaux', NiveauController::class);
    Route::resource('membres', MembresController::class);
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
