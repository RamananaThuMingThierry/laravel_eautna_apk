<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Axes;
use App\Models\Level;
use App\Models\Membres;
use App\Models\Filieres;
use App\Models\Fonctions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class MembresController extends Controller
{
    
    public function index(){

        $membres = Membres::orderBy('numero_carte')
        ->with('users:id,image,pseudo')
        ->get();

        return response()->json([
            'membres' => $membres
        ]);
    }

    public function store(Request $request){

        $autorisation = false;
        $user = auth()->user();

        if($user){

            if($user->status){
                if($user->roles == "Administrateurs"){
                    $autorisation = true;
                }
            }

            if($autorisation){

                // Déclarations des variables
                $numero_carte = $request->numero_carte;
                $nom = $request->nom;
                $prenom = $request->prenom;
                $date_de_naissance = $request->date_de_naissance;
                $lieu_de_naissance = $request->lieu_de_naissance;
                $cin = $request->cin;
                $genre = $request->genre;
                $contact_personnel = $request->contact_personnel;
                $contact_tutaire = $request->contact_tutaire;
                $sympathisant = $request->sympathisant;
                $fonctions_id = $request->fonctions_id;
                $filieres_id = $request->filieres_id;
                $levels_id = $request->levels_id;
                $axes_id = $request->axes_id;
                $adresse = $request->adresse;
                $facebook = $request->facebook;
                $date_inscription = $request->date_inscription;

                $image = $this->saveImage($request->image, 'membres');

                $validator = Validator::make($request->all(), [
                    'numero_carte' => 'required|numeric',
                    'nom' => [
                        'required',
                        Rule::unique('membres')->where(function ($query) use ($request) {
                            return $query->where('prenom', $request->prenom);
                        }),
                    ],
                    'date_de_naissance' => [
                        'required',
                        'date',
                        function ($attribute, $value, $fail) {
                            // Convert the input to a Carbon instance
                            $date = Carbon::createFromFormat('Y-m-d', $value);

                            // Check if the conversion was successful and the date is valid
                            if (!$date || $date->format('Y-m-d') !== $value) {
                                $fail($attribute.' n\'est pas une date valide ou n\'est pas au format Y-m-d.');
                            }
                        },
                    ],
                    'date_inscription' => [
                        'required',
                        'date',
                        function ($attribute, $value, $fail) {
                            // Convert the input to a Carbon instance
                            $date = Carbon::createFromFormat('Y-m-d', $value);

                            // Check if the conversion was successful and the date is valid
                            if (!$date || $date->format('Y-m-d') !== $value) {
                                $fail($attribute.' n\'est pas une date valide ou n\'est pas au format Y-m-d.');
                            }
                        },
                    ],
                    'lieu_de_naissance' => 'required|string',
                    'cin' => 'required|string|min:12|max:12|unique:membres',
                    'genre' => 'required|string',
                    'contact_personnel' => 'required|max:10|min:10|string',
                    'contact_tutaire' => 'required|max:10|min:10|string',
                    'sympathisant' => 'required|boolean',
                    'fonctions_id' => 'required|integer',
                    'filieres_id' => 'required|integer',
                    'levels_id' => 'required|integer',
                    'axes_id' => 'required|integer',
                    'facebook' => 'required|string',
                    'adresse' => 'required|string',
                ]);        
        
                if($validator->fails())
                {
                    return response()->json([
                        'errors' => $validator->messages(),
                    ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
                }
                else
                {   
                    // Verification fonctions_id
                    $verification_fonctions = Fonctions::where('id', $fonctions_id)->exists();
                    if($verification_fonctions == false){
                        return response()->json([
                            'message' => 'Cet fonction n\'existe pas dans la base de données!'
                        ], 404);
                    }

                    // Verification filieres_id
                    $verification_filieres = Filieres::where('id', $filieres_id)->exists();
                    if($verification_filieres == false){
                        return response()->json([
                            'message' => 'Cet filiere n\'existe pas dans la base de données!'
                        ], 404);
                    }

                     // Verification niveau
                     if($levels_id != 0){
                        $verification_niveau = Level::where('id', $levels_id)->exists();
                        if($verification_niveau == false){
                            return response()->json([
                                'message' => 'Ce niveau n\'existe pas dans la base de données!'
                            ], 404);
                        }
                     }

                     // Verification axes_id
                     if($axes_id != 0){
                        $verification_axes = Axes::where('id', $axes_id)->exists();
                        if($verification_axes == false){
                            return response()->json([
                                'message' => 'Cet axes n\'existe pas dans la base de données!'
                            ], 404);
                        }
                     }

                    // Verification sympathisant
                    if($sympathisant){
                        if($axes_id != 0){
                            return response()->json([
                                'message' => 'Veuillez verifier si vous êtes sympathisant(e) ou pas!'
                            ], 403);
                        }
                    }      
                    
                    // Vérification filière et niveau
                    if($levels_id == 0){
                        $verification_filieres = Filieres::find($filieres_id);

                        if($verification_filieres->nom_filieres != "Nouveau bachelier"){
                            return response()->json([
                                'message' => 'Veuillez séléctionner votre niveau!'
                            ], 403);
                        }
                    }

                    Membres::create([
                        'numero_carte' => $numero_carte,
                        'nom' => $nom,
                        'prenom' => $prenom,
                        'date_de_naissance' => $date_de_naissance,
                        'lieu_de_naissance' => $lieu_de_naissance,
                        'cin' => $cin,
                        'genre' => $genre,
                        'contact_personnel' => $contact_personnel,
                        'contact_tutaire' => $contact_tutaire,
                        'sympathisant' => $sympathisant,
                        'fonctions_id' => $fonctions_id,
                        'filieres_id' => $filieres_id,
                        'levels_id' => $levels_id,
                        'axes_id' => $axes_id,
                        'facebook' => $facebook,
                        'adresse' => $adresse,
                        'users_id' => $user->id,
                        'image' => $image,
                        'date_inscription' => $date_inscription
                    ]);

                    return response()->json([
                        'message' => 'Enregistrement effectuer!'
                    ], 200);
                }

            }else{
                return response()->json([
                    'message' => "Accès interdit! Vous n'avez pas eu le droit à effectuer cet opération!"
                ], 403);    
            }
        }else{
            return response()->json([
                'message' => "Accès interdit! Veuillez vous authentifier!"
            ], 401);
        }

    }

    public function show($membres_id){

        $membres = Membres::where('id', $membres_id)->with('users:id,pseudo,image')->first();

        if($membres){

            return response()->json([
                'membres' => $membres 
            ], 200);

        }else{
            return response()->json([
                'message' => 'Ce membre n\'existe pas dans la base de données!'
            ], 404);
        }
        
    }

    public function getMembre($id){

        $user = auth()->user();

        if($user){

            $membres = Membres::where('lien_membre_id', $id)->with('users:id,pseudo,image')->first();

            return response()->json([
                'membres' => $membres 
            ], 200);
    
        }else{
            return response()->json([
                'message' => 'Accès interdit! Veuillez vous authentifiez!'
            ], 401);
        }        
    }

    public function delete($membres_id){
        $autorisation = false;

        $user = auth()->user();

        if($user){

            if($user->status){
                if($user->roles == "Administrateurs"){
                    $autorisation = true;
                }
            }

            if($autorisation){

                $membres = Membres::find($membres_id);

                if($membres){

                    $membres->delete();

                    return response()->json([
                        'message' => "Suppression réussi!"
                    ], 200);

                }else{
                    return response()->json([
                        'message' => "Ce membre n'existe pas dans la base de données!"
                    ], 404);
                }

            }else{
                return response()->json([
                    'message' => "Accès interdit! Vous n'avez pas eu le droit à effectuer cet opération!"
                ], 403);    
            }
        }else{
            return response()->json([
                'message' => "Accès interdit! Veuillez vous authentifier!"
            ], 401);
        }
    }

}
