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
            'Centre Ville' => $nombreTotalCentreVille,
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

    public function filtreAxesMembre($axes_id){
        $user = auth()->user();

        if($user){
            $membres = Membres::where('axes_id', $axes_id)
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
    
    public function filtreNiveauMembre($levels_id){
        $user = auth()->user();

        if($user){
            $membres = Membres::where('levels_id', $levels_id)
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

    public function filtreFiliereMembre($filieres_id){
        $user = auth()->user();

        if($user){
            $membres = Membres::where('filieres_id', $filieres_id)
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
    
    public function filtreFonctionMembre($fonctions_id){
        $user = auth()->user();

        if($user){
            
            $membres = Membres::where('fonctions_id', $fonctions_id)
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
                $contact_tuteur = $request->contact_tuteur;
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
                    'contact_personnel' => 'required|max:10|min:10|string|unique:membres',
                    'contact_tuteur' => 'required|max:10|min:10|string',
                    'sympathisant' => 'required|boolean',
                    'fonctions_id' => 'required|integer',
                    'filieres_id' => 'required|integer',
                    'levels_id' => 'required|integer',
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
                    if(intval($axes_id) != 0){
                        $verification_axes = Axes::where('id', $axes_id)->exists();
                        if($verification_axes == false){
                            return response()->json([
                                'message' => $axes_id
                            ], 404);
                        }
                    }
                    

                    // Verification sympathisant
                    if($sympathisant){
                        if(intval($axes_id) != 0){
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

                    $data = [
                        'numero_carte' => $numero_carte,
                        'nom' => $nom,
                        'prenom' => $prenom == "null" ? null : $prenom,
                        'date_de_naissance' => $date_de_naissance,
                        'lieu_de_naissance' => $lieu_de_naissance,
                        'cin' => $cin,
                        'genre' => $genre,
                        'contact_personnel' => $contact_personnel,
                        'contact_tuteur' => $contact_tuteur,
                        'sympathisant' => $sympathisant,
                        'fonctions_id' => $fonctions_id,
                        'filieres_id' => $filieres_id,
                        'levels_id' => $levels_id,
                        'sections_id' => $sections_id,
                        'facebook' => $facebook,
                        'adresse' => $adresse,
                        'users_id' => $user->id,
                        'image' => $image,
                        'date_inscription' => $date_inscription
                    ];

                    
                    // Vérifiez si 'axes_id' est défini dans les données du formulaire et qu'il n'est pas vide
                    if ($request->axes_id != "null"){
                        // Vérifiez si la valeur est égale à "0" ou 0
                        if ($request->axes_id === "0" || $request->axes_id === 0) {
                            // Assurez-vous qu'il s'agit d'un entier
                            $data['axes_id'] = null;
                        } else {
                            // Assurez-vous qu'il s'agit d'un entier
                            $data['axes_id'] = (int)$request->axes_id;
                        }
                    } else {
                        // Si 'axes_id' n'est pas défini, définissez-le sur null
                        $data['axes_id'] = null;
                    }
                    

                    Membres::create($data);

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

    public function update($membreIdUpdate, Request $request){

        $autorisation = false;

        $user = auth()->user();
        
        if($user){

            if($user->status){
                if($user->roles == "Administrateurs"){
                    $autorisation = true;
                }
            }
            
            if($autorisation){

                // Vérifions si id membre existe dans la base de données
                $verifier_membre_existe = Membres::where('id', $membreIdUpdate)->exists();
                if($verifier_membre_existe){

                    $get_membre_update = Membres::find($membreIdUpdate);

                        // Déclarations des variables
                    $numero_carte = $request->numero_carte;
                    $nom = $request->nom;
                    $prenom = $request->prenom;
                    $date_de_naissance = $request->date_de_naissance;
                    $lieu_de_naissance = $request->lieu_de_naissance;
                    $cin = $request->cin;
                    $genre = $request->genre;
                    $contact_personnel = $request->contact_personnel;
                    $contact_tuteur = $request->contact_tuteur;
                    $sympathisant = $request->sympathisant;
                    $fonctions_id = $request->fonctions_id;
                    $filieres_id = $request->filieres_id;
                    $sections_id = $request->sections_id;
                    $levels_id = $request->levels_id;
                    $axes_id = $request->axes_id;
                    $adresse = $request->adresse;
                    $facebook = $request->facebook;
                    $date_inscription = $request->date_inscription;
                    
                    $validator = Validator::make($request->all(), [
                        'numero_carte' => 'required|numeric',
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
                        'genre' => 'required|string',
                        'contact_personnel' => 'required|max:10|min:10|string',
                        'contact_tuteur' => 'required|max:10|min:10|string',
                        'sympathisant' => 'required|boolean',
                        'fonctions_id' => 'required|integer',
                        'filieres_id' => 'required|integer',
                        'levels_id' => 'required|integer',
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

                        $nomComplet = $nom . ' '. $prenom;
                        // Verifions si nom et prénom existe dans la base de données
                        $verifions_nom_prenoms = Membres::whereRaw('CONCAT(nom, " ", prenom) = ?', [$nomComplet])->exists();
                        if($verifions_nom_prenoms){
                             $get_nom_prenoms = Membres::whereRaw('CONCAT(nom, " ", prenom) = ?', [$nomComplet])->first();
                            if($get_nom_prenoms->id != $membreIdUpdate){
                                return response()->json([
                                    'message' => 'Cette membre existe déjà dans la base de données!'
                                ], 403);
                            }
                        }

                        
                        
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

                        // Verification sympathisant
                        if($sympathisant){
                            if($axes_id != "null"){
                                return response()->json([
                                    'message' => $this->constantes['Sympathisant']
                                ], 403);
                            }
                        }else if($axes_id == "0" || $axes_id == null){
                            return response()->json([
                                'message' => $this->constantes['Sympathisant']
                            ], 403);
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

                        // Vérifions si votre contact personnel appartient à un autre personne
                        $verifications_contact_personnl_existe = Membres::where('contact_personnel', $contact_personnel)->exists();

                        if($verifications_contact_personnl_existe){
                            $get_contact_personnl_existe = Membres::where('contact_personnel', $contact_personnel)->first();
                            if($get_contact_personnl_existe->id != $membreIdUpdate){
                                return response()->json([
                                    'message' => 'Votre contact personnel appartient à un autre membre!'
                                ], 404);
                            }
                        }

                    $data = [
                        'numero_carte' => $numero_carte,
                        'nom' => $nom,
                        'prenom' => $prenom,
                        'date_de_naissance' => $date_de_naissance,
                        'lieu_de_naissance' => $lieu_de_naissance,
                        'genre' => $genre,
                        'contact_personnel' => $contact_personnel,
                        'contact_tuteur' => $contact_tuteur,
                        'sympathisant' => $sympathisant,
                        'fonctions_id' => $fonctions_id,
                        'filieres_id' => $filieres_id,
                        'levels_id' => $levels_id,
                        'axes_id' => $axes_id,
                        'sections_id' => $sections_id,
                        'facebook' => $facebook,
                        'adresse' => $adresse,
                        'users_id' => $user->id,
                        'date_inscription' => $date_inscription
                    ];

                    // Verifions si cin existe dans la base de données dans le cas il n'est pas null
                    if($cin != "null"){
                        $verifions_cin_existe = Membres::where('cin', $cin)->exists();
                        if($verifions_cin_existe){
                            $get_cin_existe = Membres::where('cin', $cin)->first();
                            if($get_cin_existe->id != $membreIdUpdate){
                                return response()->json([
                                    'message' => 'C.I.N appartient à un autre membre!'
                                ], 403);
                            }
                        }

                        if(strlen($cin) !== 12){
                            return response()->json([
                                'message' => $cin
                            ], 403);
                        }

                        $data['cin'] = $cin;

                    }else{
                        $data['cin'] = null;
                    }

                        // Vérifiez si 'axes_id' est défini dans les données du formulaire et qu'il n'est pas vide
                    if ($request->axes_id != "null"){
                        // Vérifiez si la valeur est égale à "0" ou 0
                        if ($request->axes_id === "0" || $request->axes_id === 0) {
                            // Assurez-vous qu'il s'agit d'un entier
                            $data['axes_id'] = null;
                        } else {
                            // Assurez-vous qu'il s'agit d'un entier
                            $data['axes_id'] = (int)$request->axes_id;
                        }
                    } else {
                        // Si 'axes_id' n'est pas défini, définissez-le sur null
                        $data['axes_id'] = null;
                    }

                    // Sous-chaîne à rechercher
                    $sousChaine = "http://192.168.1.107:8000/storage/membres/";
                    if (strpos($request->image, $sousChaine) === false) {
                        $image = $this->saveImage($request->image, 'membres');
                        $data['image'] = $image;
                    }

                        $get_membre_update->update($data);
                        
                        return response()->json([
                            'message' => $this->constantes['Modification']
                        ], 200);
                    }

                }else{
                    return response()->json([
                        'message' => 'Cette membre '.$this->constantes['NExistePasDansBD']
                    ], 404);
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

    public function searchNameOrNumber($value){
        $user = auth()->user();

        if($user){
            if(preg_match('/^\d+$/', $value)){
                $membres = Membres::where('numero_carte','like', '%'. $value . '%') ->with('users:id,image,pseudo,email')->get();
            }else{
                // Vérifier si le terme de recherche contient un espace
                if (strpos($value, ' ') !== false) {
                    // Si le terme de recherche contient un espace, rechercher par nom et prénom ensemble
                    $membres = Membres::whereRaw('CONCAT(nom, " ", prenom) LIKE ?', ['%' . $value . '%'])
                    ->with('users:id,image,pseudo,email')
                    ->get();
                } else {
                    // Sinon, rechercher dans les colonnes du nom et du prénom séparément
                    $membres = Membres::where('nom', 'like', '%' . $value . '%')
                                ->orWhere('prenom', 'like', '%' . $value . '%')
                                ->with('users:id,image,pseudo,email')
                                ->get();
                }

                // $membres = Membres::where('nom', 'like', '%' . $value . '%')
                // ->orWhere('prenom', 'like', '%' . $value . '%')
                // ->with('users:id,image,pseudo,email')
                // ->get();
            }
            return response()->json([
                'membres' => $membres
            ], 200);
        }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);
        }
    }

    public function searchNameOrNumberAxesMembres($value, $axes_id){
        
        $user = auth()->user();

        if($user){
            if(preg_match('/^\d+$/', $value)){
                $membres = Membres::where('numero_carte','like', '%'. $value . '%')
                ->where('axes_id', $axes_id)    
                ->with('users:id,image,pseudo,email')
                ->get();
            }else{
               // Vérifier si le terme de recherche contient un espace
                if (strpos($value, ' ') !== false) {
                    // Si le terme de recherche contient un espace, rechercher par nom et prénom ensemble
                    $membres = Membres::whereRaw('CONCAT(nom, " ", prenom) LIKE ?', ['%' . $value . '%'])
                    ->where('axes_id', $axes_id)    
                    ->with('users:id,image,pseudo,email')
                    ->get();
                } else {
                    // Sinon, rechercher dans les colonnes du nom et du prénom séparément
                    $membres = Membres::where('axes_id', $axes_id)
                    ->where(function ($query) use ($value) {
                        $query->where('nom', 'like', '%' . $value . '%')
                            ->orWhere('prenom', 'like', '%' . $value . '%');
                    })
                    ->with('users:id,image,pseudo,email')
                    ->get();
                }
            }
            return response()->json([
                'membres' => $membres
            ], 200);
        }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);
        }

    }

    public function searchNameOrNumberNiveauMembres($value, $levels_id){
        
        $user = auth()->user();

        if($user){
            if(preg_match('/^\d+$/', $value)){
                $membres = Membres::where('numero_carte','like', '%'. $value . '%')
                ->where('levels_id', $levels_id)    
                ->with('users:id,image,pseudo,email')
                ->get();
            }else{
               // Vérifier si le terme de recherche contient un espace
                if (strpos($value, ' ') !== false) {
                    // Si le terme de recherche contient un espace, rechercher par nom et prénom ensemble
                    $membres = Membres::whereRaw('CONCAT(nom, " ", prenom) LIKE ?', ['%' . $value . '%'])
                    ->where('levels_id', $levels_id)    
                    ->with('users:id,image,pseudo,email')
                    ->get();
                } else {
                    // Sinon, rechercher dans les colonnes du nom et du prénom séparément
                    $membres = Membres::where('levels_id', $levels_id)
                    ->where(function ($query) use ($value) {
                        $query->where('nom', 'like', '%' . $value . '%')
                            ->orWhere('prenom', 'like', '%' . $value . '%');
                    })
                    ->with('users:id,image,pseudo,email')
                    ->get();
                }
            }
            return response()->json([
                'membres' => $membres
            ], 200);
        }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);
        }

    }

    public function searchNameOrNumberFiliereMembres($value, $filieres_id){
        
        $user = auth()->user();

        if($user){
            if(preg_match('/^\d+$/', $value)){
                $membres = Membres::where('numero_carte','like', '%'. trim($value). '%')
                ->where('filieres_id', $filieres_id)    
                ->with('users:id,image,pseudo,email')
                ->get();
            }else{
               // Vérifier si le terme de recherche contient un espace
                if (strpos($value, ' ') !== false) {
                    // Si le terme de recherche contient un espace, rechercher par nom et prénom ensemble
                    $membres = Membres::whereRaw('CONCAT(nom, " ", prenom) LIKE ?', ['%' . $value . '%'])
                    ->where('filieres_id', $filieres_id)    
                    ->with('users:id,image,pseudo,email')
                    ->get();
                } else {
                    // Sinon, rechercher dans les colonnes du nom et du prénom séparément
                    $membres = Membres::where('filieres_id', $filieres_id)
                    ->where(function ($query) use ($value) {
                        $query->where('nom', 'like', '%' . $value . '%')
                            ->orWhere('prenom', 'like', '%' . $value . '%');
                    })
                    ->with('users:id,image,pseudo,email')
                    ->get();
                }
            }
            return response()->json([
                'membres' => $membres
            ], 200);
        }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);
        }

    }
    
    public function searchNameOrNumberFonctionMembres($value, $fonctions_id){
        
        $user = auth()->user();

        if($user){
            if(preg_match('/^\d+$/', $value)){
                $membres = Membres::where('numero_carte','like', '%'. trim($value). '%')
                ->where('fonctions_id', $fonctions_id)    
                ->with('users:id,image,pseudo,email')
                ->get();
            }else{
               // Vérifier si le terme de recherche contient un espace
                if (strpos($value, ' ') !== false) {
                    // Si le terme de recherche contient un espace, rechercher par nom et prénom ensemble
                    $membres = Membres::whereRaw('CONCAT(nom, " ", prenom) LIKE ?', ['%' . $value . '%'])
                    ->where('fonctions_id', $fonctions_id)    
                    ->with('users:id,image,pseudo,email')
                    ->get();
                } else {
                    // Sinon, rechercher dans les colonnes du nom et du prénom séparément
                    $membres = Membres::where('fonctions_id', $fonctions_id)
                    ->where(function ($query) use ($value) {
                        $query->where('nom', 'like', '%' . $value . '%')
                            ->orWhere('prenom', 'like', '%' . $value . '%');
                    })
                    ->with('users:id,image,pseudo,email')
                    ->get();
                }
            }
            return response()->json([
                'membres' => $membres
            ], 200);
        }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
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
