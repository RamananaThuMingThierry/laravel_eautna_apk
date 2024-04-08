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
use App\Http\Controllers\SectionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/** --------- Public Routes ---------- **/
Route::post("/register", [AuthController::class, 'register']);
Route::post("/login", [AuthController::class, 'login']);

/** --------- Protected Routes --------- **/
Route::group(['middleware' => ['auth:sanctum']], function(){

    /** ---------- Users ---------- */
    Route::get('/users_all', [AuthController::class, "index"]);
    Route::get('/users_en_attente', [AuthController::class, "utilisateurs_en_attente"]);
    Route::get('/users_valide', [AuthController::class, "utilisateurs"]);
    Route::put('/users/{id}', [AuthController::class, "update_profile"]);
    Route::put('/users_role_user/{id}', [AuthController::class, "update_role_user"]);
    Route::put('/users_valide/{userId}/{membreId}', [AuthController::class, "valideUsers"]);
    Route::get('/users', [AuthController::class, "profiles"]);
    Route::get('/users/{id}', [AuthController::class, "show"]);
    Route::delete('/users/{id}', [AuthController::class, "delete"]);
    Route::post('/logout', [AuthController::class, "logout"]);

    /** ------------ Sections ------------ */
    Route::get('/sections', [SectionsController::class, "index"]);
    Route::get('/sections/{id}', [SectionsController::class, "show"]);
    
    /** ------------ Axes ------------ */
    Route::get('/axes', [AxesController::class, "index"]);
    Route::post('/axes', [AxesController::class, "store"]);
    Route::get('/axes/{id}', [AxesController::class, "show"]);
    Route::put('/axes/{id}', [AxesController::class, "update"]);
    Route::get('/axes_search/{id}', [AxesController::class, "search"]);
    Route::delete('/axes/{id}', [AxesController::class, "delete"]);
    
    /** ------------ Fonctions ------------ */
    Route::get('/fonctions', [FonctionsController::class, "index"]);
    Route::post('/fonctions', [FonctionsController::class, "store"]);
    Route::get('/fonctions/{id}', [FonctionsController::class, "show"]);
    Route::put('/fonctions/{id}', [FonctionsController::class, "update"]);
    Route::get('/fonctions_search/{id}', [FonctionsController::class, "search"]);
    Route::delete('/fonctions/{id}', [FonctionsController::class, "delete"]);
    
    /** ------------ Filières ------------ */
    Route::get('/filieres', [FilieresController::class, "index"]);
    Route::post('/filieres', [FilieresController::class, "store"]);
    Route::get('/filieres/{id}', [FilieresController::class, "show"]);
    Route::put('/filieres/{id}', [FilieresController::class, "update"]);
    Route::get('/filieres_search/{id}', [FilieresController::class, "search"]);
    Route::delete('/filieres/{id}', [FilieresController::class, "delete"]);
  
    /** ------------ Niveau ------------ */
    Route::get('/niveau', [NiveauController::class, "index"]);
    Route::post('/niveau', [NiveauController::class, "store"]);
    Route::get('/niveau/{id}', [NiveauController::class, "show"]);
    Route::put('/niveau/{id}', [NiveauController::class, "update"]);
    Route::get('/niveau_search/{id}', [NiveauController::class, "search"]);
    Route::delete('/niveau/{id}', [NiveauController::class, "delete"]);
    
    /** ------------ Membres ------------ */
    
    Route::get('/membres_getAllUsersNonPasUtilisateurs', [MembresController::class, "getAllUsersNonPasUtilisateurs"]);
    Route::get('/membres_statistiques', [MembresController::class, "statistiques"]);
    Route::get('/membres_search/{value}', [MembresController::class, "searchNameOrNumber"]);
    Route::get('/membres_search_axes/{value}/{axesId}', [MembresController::class, "searchNameOrNumberAxesMembres"]);
    Route::get('/membres_search_niveau/{value}/{niveauId}', [MembresController::class, "searchNameOrNumberNiveauMembres"]);
    Route::get('/membres_search_filiere/{value}/{niveauId}', [MembresController::class, "searchNameOrNumberFiliereMembres"]);
    Route::get('/membres_search_fonction/{value}/{niveauId}', [MembresController::class, "searchNameOrNumberFonctionMembres"]);
    Route::get('/membres_filtreAxesMembre/{id}', [MembresController::class, "filtreAxesMembre"]);
    Route::get('/membres_filtreNiveauMembre/{id}', [MembresController::class, "filtreNiveauMembre"]);
    Route::get('/membres_filtreFiliereMembre/{id}', [MembresController::class, "filtreFiliereMembre"]);
    Route::get('/membres_filtreFonctionMembre/{id}', [MembresController::class, "filtreFonctionMembre"]);
    Route::get('/membres_filtreAll/{fonction}/{filiere}/{niveau}/{section}/{axes}/{genre}/{sympathisant}', [MembresController::class, "filtreAll"]);
    Route::get('/membres_searchInfiltreAll/{value}/{fonction}/{filiere}/{niveau}/{section}/{axes}/{genre}/{sympathisant}', [MembresController::class, "searchInfiltreAll"]);
    Route::get('/membres', [MembresController::class, "index"]);
    Route::post('/membres', [MembresController::class, "store"]);
    Route::get('/membres/{id}', [MembresController::class, "show"]);
    Route::get('/getmembres/{id}', [MembresController::class, "getMembre"]);
    Route::get('/membres_numero/{debutNumero}', [MembresController::class, "ListeDesNumero"]);
    Route::put('/membres/{id}', [MembresController::class, "update"]);
    Route::delete('/membres/{id}', [MembresController::class, "delete"]);

});
