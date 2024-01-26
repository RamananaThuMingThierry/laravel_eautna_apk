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

       $user = auth()->user();

       if($user){
            $niveau = Level::orderBy('niveau')->with('users:id,pseudo,contact,image,adresse')->get();

            return Response()->json([
                'niveau' => $niveau
            ], 200);
       }else{
            return response()->json([
                'message' =>  $this->constantes['NonAuthentifier']
            ], 401);
       }
    }

    public function search($value){

        $user = auth()->user();

        if($user){
            
            $niveau = Level::where('niveau', 'like', "%$value%")->with('users:id,pseudo,image')->get();

            return response()->json([
                'niveau' => $niveau
            ], 200);
        }else{
            return response()->json([
                'message' =>  $this->constantes['NonAuthentifier']
        ], 401);
        }
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
                        'message' => $this->constantes['Reussi']
                    ], 200);
                
                }
            }else{

                return response()->json([
                    'message' =>  $this->constantes['Permission']
                ], 403);
                
            }

        }else{
                
            return response()->json([
                'message' =>  $this->constantes['NonAuthentifier']
            ], 401);

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
                    'message' => 'Ce niveau '. $this->constantes['NExistePasDansBD']
                ], 404);
            }

        }else{
            return response()->json([
                    'message' =>  $this->constantes['NonAuthentifier']
            ], 401);
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
                                    return response()->json([
                                        'message' =>  $this->constantes['PasDeChangement']
                                    ], 304);
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
                                    'message' =>  $this->constantes['Modification']
                                ], 200);

                            }else{
                                return response()->json([
                                    'message' => 'Ce niveau '.$this->constantes['ExisteDansBD']
                                ], 403);
                            }
                        }
                }else{
                    return response()->json([
                        'message' => 'Ce niveau '. $this->constantes['NExistePasDansBD']
                    ], 404);
                }
            }else{
                return response()->json([
                    'message' =>  $this->constantes['Permission']
                ], 403);
            }
        }else{
            return response()->json([
                    'message' =>  $this->constantes['NonAuthentifier']
            ], 401);
        }
    }

    public function delete($niveau_id){

        $users = auth()->user();

        if($users){
            
            $niveau = Level::where('id',$niveau_id)->with('users:id,pseudo,contact,adresse,image')->first();
            
            if($users->roles == "Administrateurs"){
                
                if($niveau){

                    $niveau->delete();

                    return response()->json([
                        'message' =>  $this->constantes['Suppression']
                    ], 200); 

                }else{
                    return response()->json([
                        'message' => 'Ce niveau '. $this->constantes['NExistePasDansBD']
                    ], 404);
                }
            }else{
                return response()->json([
                    'message' => $this->constantes['Permission']
                ], 403);
            }
        }else{         
            return response()->json([
                    'message' =>  $this->constantes['NonAuthentifier']
            ], 401);
        }
    }
}
