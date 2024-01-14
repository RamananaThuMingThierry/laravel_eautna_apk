<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\AxesController;
use App\Http\Controllers\CommentairesController;
use App\Http\Controllers\FilieresController;
use App\Http\Controllers\FonctionsController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\MembresController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\MoisController;
use App\Http\Controllers\NiveauController;
use App\Http\Controllers\PortesController;
use App\Http\Controllers\PostController;
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

    /** ------------ Axes ------------ */
    Route::get('/axes', [AxesController::class, "index"]);
    Route::post('/axes', [AxesController::class, "store"]);
    Route::get('/axes/{id}', [AxesController::class, "show"]);
    Route::put('/axes/{id}', [AxesController::class, "update"]);
    Route::delete('/axes/{id}', [AxesController::class, "delete"]);
    
    /** ------------ Fonctions ------------ */
    Route::get('/fonctions', [FonctionsController::class, "index"]);
    Route::post('/fonctions', [FonctionsController::class, "store"]);
    Route::get('/fonctions/{id}', [FonctionsController::class, "show"]);
    Route::put('/fonctions/{id}', [FonctionsController::class, "update"]);
    Route::delete('/fonctions/{id}', [FonctionsController::class, "delete"]);
    
    /** ------------ Filières ------------ */
    Route::get('/filieres', [FilieresController::class, "index"]);
    Route::post('/filieres', [FilieresController::class, "store"]);
    Route::get('/filieres/{id}', [FilieresController::class, "show"]);
    Route::put('/filieres/{id}', [FilieresController::class, "update"]);
    Route::delete('/filieres/{id}', [FilieresController::class, "delete"]);
  
    /** ------------ Niveau ------------ */
    Route::get('/niveau', [NiveauController::class, "index"]);
    Route::post('/niveau', [NiveauController::class, "store"]);
    Route::get('/niveau/{id}', [NiveauController::class, "show"]);
    Route::put('/niveau/{id}', [NiveauController::class, "update"]);
    Route::delete('/niveau/{id}', [NiveauController::class, "delete"]);
    
    /** ------------ Post ------------ */
    Route::get('/posts', [PostController::class, "index"]);
    Route::post('/posts', [PostController::class, "store"]);
    Route::get('/posts/{id}', [PostController::class, "show"]);
    Route::put('/posts/{id}', [PostController::class, "update"]);
    Route::delete('/posts/{id}', [PostController::class, "delete"]);
    
    /** ------------ Commentaires ------------ */
    Route::get('/posts/{id}/commentaires', [CommentairesController::class, "index"]);
    Route::post('/posts/{id}/commentaires', [CommentairesController::class, "store"]);
    Route::get('/commentaires/{id}', [CommentairesController::class, "show"]);
    Route::put('/commentaires/{id}', [CommentairesController::class, "update"]);
    Route::delete('/commentaires/{id}', [CommentairesController::class, "delete"]);
    
    /** ------------ Like or dislike back a post ------------ */
    Route::post('/posts/{id}/likes', [LikesController::class, "likeOrDislike"]);

    /** ------------ Avis ------------ */
    Route::get('/avis', [AvisController::class, "index"]);
    Route::post('/avis', [AvisController::class, "store"]);
    Route::get('/avis/{id}', [AvisController::class, "show"]);
    Route::put('/avis/{id}', [AvisController::class, "update"]);
    Route::delete('/avis/{id}', [AvisController::class, "delete"]);
    
    /** ------------ Messages ------------ */
    Route::get('/messages', [MessagesController::class, "index"]);
    Route::post('/messages', [MessagesController::class, "store"]);
    Route::get('/messages/{id}', [MessagesController::class, "show"]);
    Route::put('/messages/{id}', [MessagesController::class, "update"]);
    Route::delete('/messages/{id}', [MessagesController::class, "delete"]);
    
    /** ------------ Membres ------------ */
    Route::get('/membres', [MembresController::class, "index"]);
    Route::post('/membres', [MembresController::class, "store"]);
    Route::get('/membres/{id}', [MembresController::class, "show"]);
    Route::put('/membres/{id}', [MembresController::class, "update"]);
    Route::delete('/membres/{id}', [MembresController::class, "delete"]);

    
});
