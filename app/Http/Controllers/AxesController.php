<?php

namespace App\Http\Controllers;

use App\Models\Axes;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AxesController extends Controller
{
    public function index(){

        $axes = Axes::orderBy('nom_axes')->with('users:id,pseudo,contact,image,adresse')->get();

        return Response()->json([
            'axes' => $axes
        ], 200);
    }

    public function store(Request $request){

        $nom_axes = $request->nom_axes;
        $users = auth()->user();

        $validator = Validator::make($request->all(), [
            'nom_axes' => 'required|string|unique:axes',
        ]);        
        
        if($validator->fails()){
            
            return response()->json([
                'validator_errors' => $validator->messages(),
            ], 403);

        }else{

            if($users){
                
                Axes::create([
                    'nom_axes' => $nom_axes,
                    'users_id' => auth()->user()->id
                ]);
    
                return response()->json([
                    'message' => 'Enregistrement effectuée!'
                ], 200);

            }else{
                
                return response()->json([
                    'message' => ' Veuillez vous authentifiez!'
                ], 403);

            }
        }
    }

    public function show($axes_id){

        $users = auth()->user();

        if($users){
            
            $axes = Axes::where('id',$axes_id)->with('users:id,pseudo,contact,adresse,image')->first();

            if($axes){
                return response()->json([
                    'axes' => $axes
                ], 200);
            }else{
                
                return response()->json([
                    'message' => 'Cet axes n\'existe pas dans la base de données!'
                ], 403);

            }

        }else{
                
            return response()->json([
                    'message' => ' Veuillez vous authentifiez!'
            ], 403);

        }
    }

    public function update(Request $request, $axes_id){
        $autorisation = false;

        $nom_axes = $request->nom_axes;

        $users = auth()->user();

        if($users){

            if($users->roles == "Administrateurs"){

                $axes = Axes::find($axes_id);

                if($axes){
    
                    $validator = Validator::make($request->all(), [
                            'nom_axes' => 'required|string',
                        ]);        
                        
                        if($validator->fails()){
                            
                            return response()->json([
                                'validator_errors' => $validator->messages(),
                            ], 403);
                
                        }else{
                         
                            $verification_axes = DB::table('axes')
                                ->where('nom_axes', $nom_axes)
                                ->exists();
            
                            if($verification_axes){
            
                                $get_axes_existe = Axes::where('nom_axes', $nom_axes)->first();
                                
                                if($axes->id == $get_axes_existe->id){
                                    $autorisation = true;
                                }
            
                            }else{
                                $autorisation = true;
                            }

                            if($autorisation){

                                $axes->update([
                                    'nom_axes' => $nom_axes,
                                    'users_id' => $users->id
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
                ], 403);

            }

        }else{
                
            return response()->json([
                    'message' => ' Veuillez vous authentifiez!'
            ], 403);

        }
    }
}
