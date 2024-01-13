<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\MoisController;
use App\Http\Controllers\PortesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/** --------- Public Routes ---------- **/
Route::post("/register", [AuthController::class, 'register']);
Route::post("/login", [AuthController::class, 'login']);

/** --------- Protected Routes --------- **/
Route::group(['middleware' => ['auth:sanctum']], function(){

    /** ---------- Users ---------- */
    Route::get('/users', [AuthController::class, "index"]);
    Route::put('/users', [AuthController::class, "update"]);
    Route::get('/users/{id}', [AuthController::class, "show"]);
    Route::delete('/users/{id}', [AuthController::class, "delete"]);
    Route::post('/logout', [AuthController::class, "logout"]);

});
