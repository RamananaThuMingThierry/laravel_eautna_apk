<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Axes;
use App\Models\Level;
use App\Models\Membres;
use App\Models\Filieres;
use App\Models\Fonctions;
use App\Models\sections;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class MembresController extends Controller
{

    public function statistiques(){
        $membres = Membres::all()->count();
        $nombreTotal67h = Membres::where('sections_id', 1)->count();
        $nombreTotalAmbohipo = Membres::where('sections_id', 2)->count();
        $nombreTotalAnkatsoI = Membres::where('sections_id', 3)->count();
        $nombreTotalAnkatsoII = Membres::where('sections_id', 4)->count();
        $nombreTotalCentreVille = Membres::where('sections_id', 5)->count();
        $nombreTotalRavitoto = Membres::where('sections_id', 6)->count();
        $nombreTotalItaosy = Membres::where('sections_id', 7)->count();
        $nombreTotalIvato = Membres::where('sections_id', 8)->count();
        $nombreTotalVotovorona = Membres::where('sections_id', 9)->count();
        
        return response()->json([
            'TOTAL MEMBRES' => $membres,
            '67 h' => $nombreTotal67h,
            'Ambohipo' => $nombreTotalAmbohipo,
            'Ankatso I' => $nombreTotalAnkatsoI,
            'Ankatso II' => $nombreTotalAnkatsoII,
            'Centre  Ville' => $nombreTotalCentreVille,
            'Ravitoto' => $nombreTotalRavitoto,
            'Itaosy' => $nombreTotalItaosy,
            'Ivato' => $nombreTotalIvato,
            'Votovorona' => $nombreTotalVotovorona
        ]);
    }

    public function index(){

       $user = auth()->user();

       if($user){
            $membres = Membres::orderBy('numero_carte')
            ->with('users:id,image,pseudo,email')
            ->get();

            return response()->json([
                'membres' => $membres
            ]);
       }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);
       }
    }

    public function getAllUsersNonPasUtilisateurs(){

        $user = auth()->user();
 
        if($user){
             $membres = Membres::orderBy('numero_carte')
             ->where('lien_membre_id', 0)
             ->with('users:id,image,pseudo')
             ->get();
 
             return response()->json([
                 'membres' => $membres
             ]);
        }else{
             return response()->json([
                 'message' => $this->constantes['NonAuthentifier']
             ], 401);
        }
     }

    public function ListeDesNumero($debutNumero){
        $user = auth()->user();
        
        if($user){
            if($debutNumero == "034" || $debutNumero == "038"){
                $membre = Membres::select('contact_personnel')
                ->where('contact_personnel', 'like', '038%')
                ->orWhere('contact_personnel', 'like', '034%')
                ->get();
                return response()->json([
                    'membres' => $membre
                ], 200);
            }else{
                $membre = Membres::select('contact_personnel')->where('contact_personnel', 'like', $debutNumero."%")
                ->get();
                return response()->json([
                    'membres' => $membre
                ], 200);
            }
        }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);
        }
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
                $sections_id = $request->sections_id;
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
                    'cin' => 'nullable|string|min:12|max:12|unique:membres',
                    'genre' => 'required|string',
                    'contact_personnel' => 'required|max:10|min:10|string',
                    'contact_tutaire' => 'required|max:10|min:10|string',
                    'sympathisant' => 'required|boolean',
                    'fonctions_id' => 'required|integer',
                    'filieres_id' => 'required|integer',
                    'levels_id' => 'required|integer',
                    'axes_id' => 'nullable|integer',
                    'sections_id' => 'required|integer',
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
                    
                    // Verifier s'il le numéro est valide ou pas
                    if($this->verifierNumeroTelephone($contact_personnel) == false){
                        return response()->json([
                            'message' => 'Votre contact personnel '.$this->constantes['Numero']
                        ], 304);
                    }

                    // Verifier s'il le numéro est valide ou pas
                    if($this->verifierNumeroTelephone($contact_personnel) == false){
                        return response()->json([
                            'message' => 'Le contact du votre tuteur '.$this->constantes['Numero']
                        ], 304);
                    }

                    // Verification fonctions_id
                    $verification_fonctions = Fonctions::where('id', $fonctions_id)->exists();
                    if($verification_fonctions == false){
                        return response()->json([
                            'message' => 'Cette fonction '.$this->constantes['NExistePasDansBD']
                        ], 404);
                    }

                    // Verification filieres_id
                    $verification_filieres = Filieres::where('id', $filieres_id)->exists();
                    if($verification_filieres == false){
                        return response()->json([
                            'message' => 'Cette filiere '.$this->constantes['NExistePasDansBD']
                        ], 404);
                    }

                     // Verification niveau
                     if($levels_id != 0){
                        $verification_niveau = Level::where('id', $levels_id)->exists();
                        if($verification_niveau == false){
                            return response()->json([
                                'message' => 'Ce niveau '.$this->constantes['NExistePasDansBD']
                            ], 404);
                        }
                     }

                     // Verification section
                     if($sections_id != 0){
                        $verification_section = sections::where('id', $sections_id)->exists();
                        if($verification_section == false){
                            return response()->json([
                                'message' => 'Cette section '.$this->constantes['NExistePasDansBD']
                            ], 404);
                        }
                     }

                    // Verification axes_id
                    if($axes_id != 0){
                        $verification_axes = Axes::where('id', $axes_id)->exists();
                        if($verification_axes == false){
                            return response()->json([
                                'message' => 'Cet axes '.$this->constantes['NExistePasDansBD']
                            ], 404);
                        }
                    }
                    

                    // Verification sympathisant
                    if($sympathisant){
                        if($axes_id != 0){
                            return response()->json([
                                'message' => $this->constantes['Sympathisant']
                            ], 403);
                        }
                    }      
                    
                    // Vérification filière et niveau
                    if($levels_id == 0){
                        $verification_filieres = Filieres::find($filieres_id);

                        if($verification_filieres->nom_filieres != "Nouveau bachelier"){
                            return response()->json([
                                'message' => $this->constantes['Selection'].' votre niveau!'
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
                        'sections_id' => $sections_id,
                        'facebook' => $facebook,
                        'adresse' => $adresse,
                        'users_id' => $user->id,
                        'image' => $image,
                        'date_inscription' => $date_inscription
                    ]);

                    return response()->json([
                        'message' => $this->constantes['Reussi']
                    ], 200);
                }

            }else{
                return response()->json([
                    'message' =>  $this->constantes['Permission']
                ], 403);    
            }
        }else{
            return response()->json([
                'message' =>  $this->constantes['NonAuthentifier']
            ], 401);
        }

    }

    public function show($membres_id){

        $user = auth()->user();

        if($user){
            $membres = Membres::where('id', $membres_id)->with('users:id,pseudo,image')->first();

            if($membres){
    
                return response()->json([
                    'membres' => $membres 
                ], 200);
    
            }else{
                return response()->json([
                    'message' => 'Cette personne '.$this->constantes['NExistePasDansBD']
                ], 404);
            }
        }else{
            return response()->json([
                'message' =>  $this->constantes['NonAuthentifier']
            ], 401);
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
                'message' => $this->constantes['NonAuthentifier']
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
                        'message' =>  $this->constantes['Suppression']
                    ], 200);

                }else{
                    return response()->json([
                        'message' => "Cette personne ".$this->constantes['NExistePasDansBD']
                    ], 404);
                }

            }else{
                return response()->json([
                    'message' => $this->constantes['Permission']
                ], 403);    
            }
        }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);
        }
    }

}
