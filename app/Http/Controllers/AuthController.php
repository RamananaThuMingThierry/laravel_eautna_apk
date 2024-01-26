<?php

namespace App\Http\Controllers;

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
       
            $user = User::where('email', $request->email)->first();

            if(!$user || !Hash::check($request->mot_de_passe, $user->mot_de_passe)){
                return response()->json([
                    'message' => 'Informations d\'identification invalides',
                ], 401);

            }else{
                
                $token = $user->createToken($user->email.'_Token')->plainTextToken;
            
                return response()->json([
                    'user' => $user,
                    'token' => $token,
                ], 200);
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
 
    public function update(Request $request)
    {
        $user = auth()->user();

        if($user){
            
            $validator = Validator::make($request->all(), [
                'pseudo' => 'required|max:255',
                'contact' => 'required|string|max:10|min:10',
                'genre' => 'required|string',
                'roles' => 'required|string',
                'adresse' => 'required|string',
                'email' => 'required|email|max:255|regex:/^[a-zA-Z0-9\.\-\_]+@[a-zA-Z0-9\.\-\_]+\.[a-zA-Z]+$/',
                'mot_de_passe' => 'required|min:6|confirmed',
            ]);
    
            if($validator->fails()){
                return response()->json([
                    'errors' => $validator->messages(),
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }else{
    
                $image = $this->saveImage($request->image, 'users');
    
                $user->update([
                    'pseudo' => $request->pseudo,
                    'contact' => $request->contact,
                    'genre' => $request->genre,
                    'roles' => $request->roles,
                    'image' => $image,
                    'adresse' => $request->adresse,
                    'email' => $request->email,
                    'mot_de_passe' => Hash::make($request->mot_de_passe)
                ]);
               
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
