<?php

namespace App\Http\Controllers;

use App\Models\Fonctions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FonctionsController extends Controller
{
    public function index(){

        $fonctions = Fonctions::orderBy('fonctions')->with('users:id,pseudo,contact,image,adresse')->get();

        return Response()->json([
            'fonctions' => $fonctions
        ], 200);
    }

    public function store(Request $request){

        $fonctions = $request->fonctions;
        $users = auth()->user();

        if($users){
        
            if($users->roles == "Administrateurs"){
        
                $validator = Validator::make($request->all(), [
                    'fonctions' => 'required|string|unique:fonctions',
                ]);        
        
                if($validator->fails()){
                    
                    return response()->json([
                        'errors' => $validator->messages(),
                    ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

                }else{                
                    
                    Fonctions::create([
                        'fonctions' => $fonctions,
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

    public function show($fonctions_id){

        $users = auth()->user();

        if($users){
            
            $fonctions = Fonctions::where('id',$fonctions_id)->with('users:id,pseudo,contact,adresse,image')->first();

            if($fonctions){
                return response()->json([
                    'fonctions' => $fonctions
                ], 200);
            }else{
                
                return response()->json([
                    'message' => 'Ce filiere n\'existe pas dans la base de données!'
                ], 403);
            }
        }else{
                
            return response()->json([
                    'message' => ' Veuillez vous authentifiez!'
            ], 403);

        }
    }

    public function update(Request $request, $fonctions_id){
        $autorisation = false;

        $nom_fonctions = $request->fonctions;

        $users = auth()->user();

        if($users){

            if($users->roles == "Administrateurs"){

                $fonctions_update = Fonctions::find($fonctions_id);

                if($fonctions_update){
    
                    $validator = Validator::make($request->all(), [
                            'fonctions' => 'required|string',
                        ]);        
                        
                        if($validator->fails()){
                            
                            return response()->json([
                                'errors' => $validator->messages(),
                            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
                
                        }else{
                         
                            $verification_fonctions = DB::table('fonctions')
                                ->where('fonctions', $nom_fonctions)
                                ->exists();
            
                            if($verification_fonctions){
            
                                $get_fonctions_existe = Fonctions::where('fonctions', $nom_fonctions)->first();
                                
                                if($fonctions_update->id == $get_fonctions_existe->id){
                                    return response()->json(
                                        ['message' => 'Aucun changement n\'a été apporté!'], 403
                                    );
                                }
            
                            }else{
                                $autorisation = true;
                            }

                            if($autorisation){

                                $fonctions_update->update([
                                    'fonctions' => $nom_fonctions,
                                    'users_id' => $users->id
                                ]);
                                
                                return response()->json([
                                    'message' => 'Modification réussi!',
                                ], 200);

                            }else{
                                return response()->json([
                                    'message' => 'Cet fonction existe déjà dans la base de données!'
                                ], 403);
                            }
                        }
                }else{
                    return response()->json([
                        'message' => 'Cet fonction n\'existe pas dans la base de données!'
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

    public function delete($fonctions_id){

        $users = auth()->user();

        if($users){
            
            $fonctions = Fonctions::where('id',$fonctions_id)->with('users:id,pseudo,contact,adresse,image')->first();

            if($fonctions){

                if($users->roles == "Administrateurs"){

                    $fonctions->delete();

                    return response()->json([
                        'message' => 'Suppression réussi!'
                    ], 200); 

                }else{
                
                    return response()->json([
                        'message' => 'Vous n\'êtes pas autorisé à supprimer cet fonction!'
                    ], 403);

                }
                
            }else{
                
                return response()->json([
                    'message' => 'Cet fonction n\'existe pas dans la base de données!'
                ], 403);

            }

        }else{
                
            return response()->json([
                    'message' => ' Veuillez vous authentifiez!'
            ], 403);

        }
    }
}
