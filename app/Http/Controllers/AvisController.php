<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AvisController extends Controller
{
    public function index(){

       $user = auth()->user();
       
       if($user){
            $avis = Avis::orderBy('created_at', 'desc')->with('users:id,pseudo,image')->get();

            return Response()->json([
                'avis' => $avis
            ], 200);
       }else{
           return response()->json([
            'message' => 'Accès interdit! Veuillez vous authentifier!'
           ], 401);
       }
    }

    public function store(Request $request){

        $message = $request->message;
        $user = auth()->user();

        if($user){
        
            if($user->status){
        
                $validator = Validator::make($request->all(), [
                    'message' => 'required|string',
                ]);        
        
                if($validator->fails()){
                    
                    return response()->json([
                        'errors' => $validator->messages(),
                    ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

                }else{                
                    
                    Avis::create([
                        'message' => $message,
                        'users_id' => auth()->user()->id
                    ]);
        
                    return response()->json([
                        'message' => 'Enregistrement effectuée!'
                    ], 200);
                
                }
            }else{

                return response()->json([
                    'message' => ' Vous \'êtes pas autorisé à effectuer cet opération!'
                ], 403);
                
            }

        }else{
                
            return response()->json([
                'message' => 'Accès Interdit! Veuillez vous authentifiez!'
            ], 401);

        }
    }

    public function show($avis_id){

        $user = auth()->user();

        if($user){
            
            if($user->roles == "Administrateurs"){

                $avis = avis::where('id', $avis_id)->with('users:id,pseudo,image')->first();

                if($avis){
                    return response()->json([
                        'avis' => $avis
                    ], 200);
                }else{
                    return response()->json([
                        'message' => 'Cet avis n\'existe pas dans la base de données!'
                    ], 404);
                }
            }else{

                return response()->json([
                    'message' => 'Accès interdit! Vous n\'est pas autorisé à effectuer cet opération!'
                ], 403);
            }
        }else{
                
            return response()->json([
                    'message' => 'Accès interdit! Veuillez vous authentifiez!'
            ], 401);

        }
    }



    public function delete($avis_id){

        $user = auth()->user();

        if($user){
            
            $avis = Avis::where('id',$avis_id)->with('users:id,pseudo,image')->first();

            if($avis){

                if($user->roles == "Administrateurs"){

                    $avis->delete();

                    return response()->json([
                        'message' => 'Suppression réussi!'
                    ], 200); 

                }else{
                
                    return response()->json([
                        'message' => 'Vous n\'êtes pas autorisé à supprimer cet avis!'
                    ], 403);

                }
                
            }else{
                
                return response()->json([
                    'message' => 'Cet avis n\'existe pas dans la base de données!'
                ], 404);

            }

        }else{
                
            return response()->json([
                    'message' => 'Accès Interdit! Veuillez vous authentifiez!'
            ], 401);

        }
    }
}
