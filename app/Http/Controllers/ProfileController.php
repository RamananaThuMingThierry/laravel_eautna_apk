<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function changer_mot_de_passe(Request $request){
       
        $user = auth()->user();

        if($user){
            $validator = Validator::make($request->all(), [
                'ancien_mot_de_passe' => 'required|min:6|max:100',
                'nouveau_mot_de_passe' => 'required|min:6|max:100',
            ]);
    
            if($validator->fails()){
                return response()->json([
                    'errors' => $validator->messages(),
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }else{
                $user = $request->user();
                if(Hash::check($request->ancien_mot_de_passe, $user->mot_de_passe)){
                    $user->update([
                        'mot_de_passe' => Hash::make($request->nouveau_mot_de_passe)
                    ]);
    
                    return response()->json([
                        'message' => 'Votre mot de passe a été bien modifier!',
                    ], 200);
                }else{
                    return response()->json([
                        'message' => 'L\'ancien mot de passe ne correspond pas!',
                    ], 403);
                }
            }
        }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);
        }
    }
}
