<?php

namespace App\Http\Controllers;

use App\Models\Filieres;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FilieresController extends Controller
{

    public function index(){

       $user = auth()->user();

       if($user){
            $filieres = Filieres::orderBy('nom_filieres')->with('users:id,pseudo,contact,image')->get();

            return Response()->json([
                'filieres' => $filieres
            ], 200);
       }else{
            return response()->json([
                'message' => 'Accès interdit! Veuillez vous authentifier!'
            ], 401);
       }
    }

    public function store(Request $request){

        $nom_filieres = $request->nom_filieres;
        $users = auth()->user();

        if($users){
        
            if($users->roles == "Administrateurs"){
        
                $validator = Validator::make($request->all(), [
                    'nom_filieres' => 'required|string|unique:filieres|alpha',
                ]);        
        
                if($validator->fails()){
                    
                    return response()->json([
                        'errors' => $validator->messages(),
                    ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

                }else{                

                    Filieres::create([
                        'nom_filieres' => $nom_filieres,
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
                'message' => 'Accès interdit! Veuillez vous authentifiez!'
            ], 401);

        }
    }

    public function show($filieres_id){

        $users = auth()->user();

        if($users){
            
            $filieres = Filieres::where('id',$filieres_id)->with('users:id,pseudo,contact,adresse,image')->first();

            if($filieres){
                return response()->json([
                    'filieres' => $filieres
                ], 200);
            }else{
                
                return response()->json([
                    'message' => 'Ce filiere n\'existe pas dans la base de données!'
                ], 404);
            }
        }else{
                
            return response()->json([
                    'message' => 'Accès interdit! Veuillez vous authentifiez!'
            ], 401);

        }
    }

    public function search($value){

        $user = auth()->user();

        if($user){
            
            $filieres = Filieres::where('nom_filieres', 'like', "%$value%")->with('users:id,pseudo,image')->get();

            return response()->json([
                'filieres' => $filieres
            ], 200);
        }else{
            return response()->json([
                'message' => 'Accès interdit! Veuillez vous authentifiez!'
        ], 401);
        }
    }

    public function update(Request $request, $filieres_id){
        $autorisation = false;

        $nom_filieres = $request->nom_filieres;

        $users = auth()->user();

        if($users){

            if($users->roles == "Administrateurs"){

                $filieres = Filieres::find($filieres_id);

                if($filieres){
    
                    $validator = Validator::make($request->all(), [
                            'nom_filieres' => 'required|string|alpha',
                        ]);        
                        
                        if($validator->fails()){
                            
                            return response()->json([
                                'errors' => $validator->messages(),
                            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
                
                        }else{
                         
                            $verification_filieres = DB::table('filieres')
                                ->where('nom_filieres', $nom_filieres)
                                ->exists();
            
                            if($verification_filieres){
            
                                $get_filieres_existe = Filieres::where('nom_filieres', $nom_filieres)->first();
                                
                                if($filieres->id == $get_filieres_existe->id){
                                    return response()->json(
                                        ['message' => 'Aucun changement n\'a été apporté!'], 304
                                    );
                                }
            
                            }else{
                                $autorisation = true;
                            }

                            if($autorisation){

                                $filieres->update([
                                    'nom_filieres' => $nom_filieres,
                                    'users_id' => $users->id
                                ]);
                                
                                return response()->json([
                                    'message' => 'Modification réussi!',
                                ], 200);

                            }else{
                                return response()->json([
                                    'message' => 'Ce filière existe déjà dans la base de données!'
                                ], 403);
                            }
                        }
                }else{
                    return response()->json([
                        'message' => "Ce filière n'existe pas dans la base de données!"
                    ], 404);
                }
            }else{
                return response()->json([
                    'message' => ' Vous n\'êtes pas autorisée à effectuer cet opération!'
                ], 403);
            }
        }else{
            return response()->json([
                    'message' => 'Accès interdit! Veuillez vous authentifiez!'
            ], 401);
        }
    }

    public function delete($filieres_id){

        $users = auth()->user();

        if($users){
            
            $filieres = Filieres::where('id',$filieres_id)->with('users:id,pseudo,contact,adresse,image')->first();

            if($filieres){

                if($users->roles == "Administrateurs"){

                    $filieres->delete();

                    return response()->json([
                        'message' => 'Suppression réussi!'
                    ], 200); 

                }else{
                
                    return response()->json([
                        'message' => 'Vous n\'êtes pas autorisé à supprimer cet filieres!'
                    ], 403);

                }
                
            }else{
                
                return response()->json([
                    'message' => 'Cet filieres n\'existe pas dans la base de données!'
                ], 404);

            }

        }else{
                
            return response()->json([
                    'message' => 'Accès interdit! Veuillez vous authentifiez!'
            ], 401);

        }
    }
}
