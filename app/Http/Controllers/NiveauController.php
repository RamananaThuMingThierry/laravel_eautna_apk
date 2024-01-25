<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NiveauController extends Controller
{
    public function index(){

        $niveau = Level::orderBy('niveau')->with('users:id,pseudo,contact,image,adresse')->get();

        return Response()->json([
            'niveau' => $niveau
        ], 200);
    }

    public function store(Request $request){

        $niveau = $request->niveau;
        $users = auth()->user();

        if($users){
        
            if($users->roles == "Administrateurs"){
        
                $validator = Validator::make($request->all(), [
                    'niveau' => 'required|string|unique:levels',
                ]);        
        
                if($validator->fails()){
                    
                    return response()->json([
                        'errors' => $validator->messages(),
                    ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

                }else{                
                    
                    Level::create([
                        'niveau' => $niveau,
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
                'message' => ' Veuillez vous authentifiez!'
            ], 403);

        }
    }

    public function show($niveau_id){

        $users = auth()->user();

        if($users){
            
            $niveau = Level::where('id',$niveau_id)->with('users:id,pseudo,contact,adresse,image')->first();

            if($niveau){
                return response()->json([
                    'niveau' => $niveau
                ], 200);
            }else{
                
                return response()->json([
                    'message' => 'Cet niveau n\'existe pas dans la base de données!'
                ], 403);

            }

        }else{
                
            return response()->json([
                    'message' => ' Veuillez vous authentifiez!'
            ], 403);

        }
    }

    public function update(Request $request, $niveau_id){
        
        $autorisation = false;

        $niveau = $request->niveau;

        $users = auth()->user();

        if($users){

            if($users->roles == "Administrateurs"){

                $niveau_update = Level::find($niveau_id);

                if($niveau_update){
    
                    $validator = Validator::make($request->all(), [
                            'niveau' => 'required|string',
                        ]);        
                        
                        if($validator->fails()){
                            
                            return response()->json([
                                'errors' => $validator->messages(),
                            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
                
                        }else{
                         
                            $verification_niveau = DB::table('levels')
                                ->where('niveau', $niveau)
                                ->exists();
            
                            if($verification_niveau){
            
                                $get_niveau_existe = Level::where('niveau', $niveau)->first();
                                
                                if($niveau_update->id == $get_niveau_existe->id){
                                    $autorisation = true;
                                }
            
                            }else{
                                $autorisation = true;
                            }

                            if($autorisation){

                                $niveau_update->update([
                                    'niveau' => $niveau,
                                    'users_id' => $users->id
                                ]);
                                
                                return response()->json([
                                    'message' => 'Modification réussi!',
                                ], 200);

                            }else{
                                return response()->json([
                                    'message' => 'Ce niveau existe déjà dans la base de données!'
                                ], 403);
                            }
                        }
                }else{
                    return response()->json([
                        'message' => 'Ce niveau n\'existe pas dans la base de données!'
                    ], 403);
                }
            }else{
                return response()->json([
                    'message' => ' Vous n\'êtes pas autorisée à effectuer cet opération!'
                ], 403);
            }
        }else{
            return response()->json([
                    'message' => ' Veuillez vous authentifiez!'
            ], 403);
        }
    }

    public function delete($niveau_id){

        $users = auth()->user();

        if($users){
            
            $niveau = Level::where('id',$niveau_id)->with('users:id,pseudo,contact,adresse,image')->first();

            if($niveau){

                if($users->roles == "Administrateurs"){

                    $niveau->delete();

                    return response()->json([
                        'message' => 'Suppression réussi!'
                    ], 200); 

                }else{
                
                    return response()->json([
                        'message' => 'Vous n\'êtes pas autorisé à supprimer ce niveau!'
                    ], 403);

                }
                
            }else{
                
                return response()->json([
                    'message' => 'Ce niveau n\'existe pas dans la base de données!'
                ], 403);

            }

        }else{
                
            return response()->json([
                    'message' => ' Veuillez vous authentifiez!'
            ], 403);

        }
    }
}
