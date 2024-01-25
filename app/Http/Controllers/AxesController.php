<?php

namespace App\Http\Controllers;

use App\Models\Axes;
use DragonCode\Contracts\Cashier\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AxesController extends Controller
{
    public function index(){

       $user = auth()->user();

       if($user){
            $axes = Axes::orderBy('nom_axes')->with('users:id,pseudo,contact,image,adresse')->get();

            return Response()->json([
                'axes' => $axes
            ], 200);
       }else{
           return Response()->json([
            'message' => 'Accès interdit! Veuillez vous authentifiez'
           ], 401);
       }

    }

    public function search($value){

        $user = auth()->user();

        if($user){
            
            $axes = Axes::where('nom_axes', 'like', "%$value%")->with('users:id,pseudo,image')->get();

            return response()->json([
                'axes' => $axes
            ], 200);
        }else{
            return response()->json([
                'message' => 'Accès interdit! Veuillez vous authentifiez!'
            ], 401);
        }
    }

    public function store(Request $request){

        $nom_axes = $request->nom_axes;
        $user = auth()->user();

        if($user){
        
            if($user->roles == "Administrateurs"){
        
                $validator = Validator::make($request->all(), [
                    'nom_axes' => 'required|string|unique:axes',
                ]);        
        
                if($validator->fails()){
                    
                    return response()->json([
                        'errors' => $validator->messages(),
                    ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

                }else{                
                    
                    Axes::create([
                        'nom_axes' => $nom_axes,
                        'users_id' => auth()->user()->id
                    ]);
        
                    return response()->json([
                        'message' => 'Enregistrement effectuée!'
                    ], 200);
                
                }
            }else{

                return response()->json([
                    'message' => "Accès interdit! Vous n'êtes pas autorisé à effectuer cet opération!"
                ], 403);
            }

        }else{
                
            return response()->json([
                'message' => 'Accès interdit! Veuillez vous authentifiez!'
            ], 401);

        }
    }

    public function show($axes_id){

        $user = auth()->user();

        if($user){
            
            $axes = Axes::where('id',$axes_id)->with('users:id,pseudo,contact,adresse,image')->first();

            if($axes){
                return response()->json([
                    'axes' => $axes
                ], 200);
            }else{
                
                return response()->json([
                    'message' => 'Cet axes n\'existe pas dans la base de données!'
                ], 404);
            }

        }else{
                
            return response()->json([
                    'message' => 'Accès interdit! Veuillez vous authentifiez!'
            ], 401);

        }
    }

    public function update(Request $request, $axes_id){
        $autorisation = false;

        $nom_axes = $request->nom_axes;

        $user = auth()->user();

        if($user){

            if($user->roles == "Administrateurs"){

                $axes = Axes::find($axes_id);

                if($axes){
    
                    $validator = Validator::make($request->all(), [
                            'nom_axes' => 'required|string',
                        ]);        
                        
                        if($validator->fails()){    
                                    
                            return response()->json([
                                'errors' => $validator->messages(),
                            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
                
                        }else{
                         
                            $verification_axes = DB::table('axes')
                                ->where('nom_axes', $nom_axes)
                                ->exists();
            
                            if($verification_axes){
            
                                $get_axes_existe = Axes::where('nom_axes', $nom_axes)->first();
                                
                                if($axes->id == $get_axes_existe->id){
                                      return response()->json([
                                        'message' => 'Aucun changement n\'a été apporté!'
                                    ], 304);
                                }
            
                            }else{
                                $autorisation = true;
                            }

                            if($autorisation){

                                $axes->update([
                                    'nom_axes' => $nom_axes,
                                    'user_id' => $user->id
                                ]);
                                
                                return response()->json([
                                    'message' => 'Modification réussi!',
                                ], 200);

                            }else{
                                return response()->json([
                                    'message' => 'Cet axes existe déjà dans la base de données!'
                                ], 403);
                            }
                        }
                }else{
                    return response()->json([
                        'message' => 'Cet axes n\'existe pas dans la base de données!'
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

    public function delete($axes_id){

        $users = auth()->user();

        if($users){
            
            $axes = Axes::where('id',$axes_id)->with('users:id,pseudo,contact,adresse,image')->first();

            if($axes){

                if($users->roles == "Administrateurs"){

                    $axes->delete();

                    return response()->json([
                        'message' => 'Suppression réussi!'
                    ], 200); 

                }else{
                
                    return response()->json([
                        'message' => 'Vous n\'êtes pas autorisé à supprimer cet axes!'
                    ], 403);

                }
                
            }else{
                
                return response()->json([
                    'message' => 'Cet axes n\'existe pas dans la base de données!'
                ], 404);

            }

        }else{
                
            return response()->json([
                    'message' => 'Accès interdit! Veuillez vous authentifiez!'
            ], 401);

        }
    }
}
