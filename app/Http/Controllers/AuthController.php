<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{  

    public function seachUsersValide($valeur){

        $user_auth = auth()->user();

        if($user_auth){
            
            $user = User::where('pseudo','like', "%$valeur%")->where('status', 1)->where('id', '<>', $user_auth->id)->get();

            return response()->json([
                'user' => $user
            ], 200);

        }else{

            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);

        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|regex:/^[a-zA-Z0-9\.\-\_]+@[a-zA-Z0-9\.\-\_]+\.[a-zA-Z]+$/',
            'mot_de_passe' => 'required|min:6',
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->messages(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }else{
            
            $user_existe = User::where('email', $request->email)->exists();

            if($user_existe){
                
                $user = User::where('email', $request->email)->first();
                
                if(!$user || !Hash::check($request->mot_de_passe, $user->mot_de_passe)){
                    return response()->json([
                        'message' => 'Informations d\'identification invalides',
                    ], 403);

                }else{
                    
                    $token = $user->createToken($user->email.'_Token')->plainTextToken;
                
                    return response()->json([
                        'user' => $user,
                        'token' => $token,
                    ], 200);
                }   
            }else{
                return response()->json([
                    'message' => 'Votre adresse email est incorrecte!',
                ], 403);
            }    
        }
    }

    public function register(Request $request)
    {
        $pseudo = $request->pseudo;
        $email = $request->email;
        $contact = $request->contact;
        $adresse = $request->adresse;
        $mot_de_passe = $request->mot_de_passe;

        $validator = Validator::make($request->all(), [
            'pseudo' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users|regex:/^[a-zA-Z0-9\.\-\_]+@[a-zA-Z0-9\.\-\_]+\.[a-zA-Z]+$/',
            'contact' => 'required|string|min:10|max:10|unique:users',
            'mot_de_passe' => 'required|min:6|confirmed',
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->messages(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }else{

            if($this->verifierNumeroTelephone($contact) == false){
                return response()->json([
                    'messge' => "Votre contact ". $this->constantes['Numero']
                ], 304);
            }

            $user = User::create([
                'pseudo' => $pseudo,
                'email' => $email,
                'contact' => $contact,
                'adresse' => $adresse,
                'mot_de_passe' => Hash::make($mot_de_passe)
            ]);

           $token = $user->createToken($user->email.'_Token')->plainTextToken;

            return response()->json([
               'user' => $user,
               'token' => $token,
            ], 200);
        }
    }
 
    // Méthode permettant de valide un utilisateur en atttente
    public function valide_un_utilisateur($users_id)
    {
        $user = auth()->user();

        if($user){
                
                // Vérifions s'il l'utilisateur existe dans la base de données
                $verifier_users_id = User::where('id', $users_id)->exists();

                if($verifier_users_id){
                
                    // Récupérer l'utilisateur
                    $get_user = User::where('id', $users_id)->first();

                    // Valide l'utilisateur en attente
                    $get_user->update([
                        'status' => 1
                    ]);

                    return response()->json([
                        'message' => "L'utilisateur a été bien approuver!"
                    ], 200);

                }else{
                    return response()->json([
                        'message' => 'Cet utilateur '. $this->constantes['NExistePasDansBD']
                    ], 404);
                }
        }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);
        }
    }

    // Méthode permettant de modifier un profile
    public function modifier_un_profile(Request $request, $userIdUpdate)
    {
        $user = auth()->user();

        if($user){
           
            $validator = Validator::make($request->all(), [
                'pseudo' => 'required|max:255',
                'contact' => 'required|string|max:10|min:10',
                'adresse' => 'required|string',
                'email' => 'required|email|max:255|regex:/^[a-zA-Z0-9\.\-\_]+@[a-zA-Z0-9\.\-\_]+\.[a-zA-Z]+$/',
            ]);
    
            if($validator->fails()){
                return response()->json([
                    'errors' => $validator->messages(),
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }else{

                $pseudo = $request->pseudo;
                $email = $request->email;
                $adresse = $request->adresse;
                $contact = $request->contact;

                // Vérifions si votre contact personnel appartient à un autre personne
                $verifications_contact_users_existe = User::where('contact', $contact)->exists();

                if($verifications_contact_users_existe){
                    $get_contact_user_existe = User::where('contact', $contact)->first();
                    if($get_contact_user_existe->id != $userIdUpdate){
                        return response()->json([
                            'message' => 'Votre contact personnel appartient à un autre utilisateur!'
                        ], 404);
                    }
                }

                $data = [
                    'pseudo' => $pseudo,
                    'contact' => $contact,
                    'adresse' => $adresse,
                    'email' => $email,
                ];

                // Sous-chaîne à rechercher
                $sousChaine = "http://192.168.1.107:8000/storage/users/";
                if (strpos($request->image, $sousChaine) === false) {
                    $image = $this->saveImage($request->image, 'users');
                    $data['image'] = $image;
                }

                $user->update($data);
               
                return response()->json([
                    'message' => $this->constantes['Modification']
                ], 200);
            }
        }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);
        }
    }

    public function update_role_user(Request $request, $userIdUpdate)
    {
        $user = auth()->user();

        if($user){
            
            if($user->status == 1){

                if($user->roles == "Administrateurs"){

                    $user_update_existe = User::where('id', $userIdUpdate)->exists();

                    if($user_update_existe){

                        $user_update = User::where('id', $userIdUpdate)->first();

                        $validator = Validator::make($request->all(), [
                            'roles' => 'required|string',
                        ]);
                
                        if($validator->fails()){
                            return response()->json([
                                'errors' => $validator->messages(),
                            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
                        }else{
            
                            $roles = $request->roles;
            
                            $data = [
                                'roles' => $roles,
                            ];
            
                            $user_update->update($data);
                        
                            return response()->json([
                                'message' => $this->constantes['Modification']
                            ], 200);
                        }
    
                    }else{
                        return response()->json([
                            'message' => 'Cet utilisateur '. $this->constantes['NExistePasDansBD']
                        ]);
                    }
                }else{
                    return response()->json([
                        'message' => $this->constantes['Permission']
                    ], 401);        
                }
            }else{

                return response()->json([
                    'message' => $this->constantes['Permission']
                ], 401);

            }
        }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);
        }
    }

    public function index(){
        $user = auth()->user();
        
        if($user){
            $users = User::where('id', '<>', $user->id)->get();
            return response()->json([
                'user' => $users
            ], 200);
        }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);
        }
    }

    // Méthode permettant de récupérer toutes les utilisateurs valide
    public function liste_des_utilisateurs_valide(){
        $user = auth()->user();
        
        if($user){
            $users = User::where('status', 1)->where('id', '<>', $user->id)->get();
            return response()->json([
                'user' => $users
            ], 200);
        }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);
        }
    }

    // Méthode permettant de récupérer toutes les utilisateurs en attente de validation
    public function liste_des_utilisateurs_en_attente(){
        $user = auth()->user();
        
        if($user){
            $users = User::where('status', 0)->get();
            return response()->json([
                'user' => $users
            ], 200);
        }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);
        }
    }

    public function profiles(){
        
        $user = auth()->user();

        if($user){
            return response()->json([
                'user' => $user
            ], 200);
        }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);
        }
    }

    public function show($users_id){
        $verifier_auth = auth()->user();
        if($verifier_auth){
        
            $user = User::find($users_id);

            if($user){

                return response()->json([
                    'user' => $user
                ], 200);

            }else{
            
                return response()->json([
                    'message' => 'Cet utilisateur '.$this->constantes['NExistePasDansBD']
                ], 404);
            }
            
        }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);
        }
    }

    public function logout(){
        $user = auth()->user();
        if($user){
            $user->tokens()->delete();
            return response()->json([
                'message' =>  $this->constantes['Deconnection']
            ], 200);
        }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);
        }
    }

    public function ReinitialiserMotDePasse(Request $request){
      
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'mot_de_passe' => 'required|string|min:6',
            'token' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

       $updatePassword = DB::table('password_reset_tokens')
        ->where([
            "email" => $request->email,
            "token" => $request->token
        ])->first();
    
       if(!$updatePassword){
        return response()->json([
            'message' => 'Désolé, l\'adresse e-mail que vous avez saisie est incorrecte. Veuillez entrer une adresse e-mail valide.'
        ], 403);
       }

       User::where("email", $request->email)->update([
        'mot_de_passe' => Hash::make($request->mot_de_passe)
       ]);

       DB::table("password_reset_tokens")->where("email", $request->email)->delete();

       return response()->json([
        'message' => 'Votre mot de passe à été réinitialiser',
       ], 200);
    }
    
    private $tokens;

    public function mot_de_passe_oublier(Request $request){
      
        $validator = Validator::make($request->all(), [
            'email' => 'required|email', // Cette règle vérifie si le champ est requis et s'il est un adresse email
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }else{

            // Vérifions s'il l'adresse email existe dans la base de données ou pas
            $valide = User::where('email', $request->email)->exists();

            if(!$valide){
                return response()->json([
                    'message' => 'Votre adresse email n\'est pas valide!'
                ], 403);
            }
        }

        $token = Str::random(64);

        // Vérifiez d'abord si l'adresse e-mail existe déjà dans la table
        $passwordReset = DB::table('password_reset_tokens')->where('email', $request->email)->first();
        
        $this->tokens = Hash::make($token);

        if ($passwordReset) {
            // L'adresse e-mail existe déjà, mettez à jour le token existant
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->update([
                    'token' => $this->tokens,
                    'created_at' => Carbon::now()
                ]);
        } else {
            // L'adresse e-mail n'existe pas encore, insérez un nouveau token
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $this->tokens,
                'created_at' => now()
            ]);
        }

        $valeur_de_recuperation = $this->genererNombreAleatoire();

        Mail::send("emails.forget-password", ['token' => $this->tokens, 'valeur_de_recuperation' => $valeur_de_recuperation], function($message) use ($request){
            $message->to($request->email);
            $message->subject("Rest Password");
        });

        return response()->json([
            'message' => 'Nous avons envoyer une email pour réinitialiser votre mot de passe',
            'token' => $this->tokens,
            'valeur_de_recuperation' => $valeur_de_recuperation
        ], 200);
    }

    public function comfirmation(Request $request){
        $validator = Validator::make($request->all(), [
            'verification' => 'required', // Cette règle vérifie si le champ est requis et s'il est numérique.
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }else{

            if($this->verifierValiditeNombreAleatoire() == (int)$request->verification){
                return response()->json([
                    'message' => 'On vous remerci pour votre comfirmation'
                ], 200);
    
            }else{
                
                return response()->json([
                    'message' => ' La validité du nombre aléatoire a expiré'
                ], 403);
    
            }
        }
    }

    public function genererNombreAleatoire()
    {
        // Générer un nombre aléatoire à 6 chiffres
        $nombreAleatoire = rand(100000, 999999);
        
        // Stocker le nombre aléatoire en cache avec une durée de validité de 10 minutes
        Cache::put('nombre_aleatoire', $nombreAleatoire, now()->addMinutes(10));
        
        return $nombreAleatoire;
    }

    public function verifierValiditeNombreAleatoire()
    {
        // Récupérer le nombre aléatoire depuis le cache
        $nombreAleatoire = Cache::get('nombre_aleatoire');

        if ($nombreAleatoire !== null) {
            // Vérifier si le nombre aléatoire est toujours valide (moins de 10 minutes écoulées)
            return $nombreAleatoire;
        } else {
            // La validité du nombre aléatoire a expiré
            return null;
        }
    }
}
