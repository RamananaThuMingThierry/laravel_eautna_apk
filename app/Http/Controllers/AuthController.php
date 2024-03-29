<?php

namespace App\Http\Controllers;

use App\Models\Membres;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Psy\Readline\Hoa\Console;

class AuthController extends Controller
{  

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
 
    public function valideUsers($users_id, $membre_id)
    {
        $user = auth()->user();

        if($user){
                
                $verifier_users_id = User::where('id', $users_id)->exists();
                if($verifier_users_id){
                    $users_update = User::find($users_id);
                    $verifier_id_membre = Membres::where('id', $membre_id)->exists();
                if($verifier_id_membre){
                    $get_membre = Membres::find($membre_id);
                    if($users_update->status == 0){
                        $users_update->update([
                            'status' => 1
                        ]);

                        $get_membre->update([
                            'lien_membre_id' => $users_update->id
                        ]);
                       
                        return response()->json([
                            'message' => $this->constantes['Modification']
                        ], 200);
                    }else{
                        return response()->json([
                            'message' => 'Cet utilisateur est déjà validé!'
                        ], 403);
                    }
                }else{
                    return response()->json([
                        'message' => 'Ce personne '. $this->constantes['NExistePasDansBD']
                    ], 404);
                }
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

    public function update_profile(Request $request, $userIdUpdate)
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

    public function utilisateurs(){
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

    public function utilisateurs_en_attente(){
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
}
