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

      $user = auth()->user();

      if($user){
        $fonctions = Fonctions::orderBy('nom_fonctions')->get();

        return Response()->json([
            'fonctions' => $fonctions
        ], 200);

      }else{
        
        return response()->json([
            'message' => $this->constantes['NonAuthentifier']
        ], 401);
      }
    }

    public function store(Request $request){

        $nom_fonctions = $request->nom_fonctions;
        $users = auth()->user();

        if($users){
        
            if($users->roles == "Administrateurs"){
        
                $validator = Validator::make($request->all(), [
                    'nom_fonctions' => 'required|string|unique:fonctions',
                ]);        
        
                if($validator->fails()){
                    
                    return response()->json([
                        'errors' => $validator->messages(),
                    ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

                }else{                
                    
                    Fonctions::create([
                        'nom_fonctions' => $nom_fonctions
                    ]);
        
                    return response()->json([
                        'message' => $this->constantes['Reussi']
                    ], 200);
                
                }
            }else{

                return response()->json([
                    'message' => $this->constantes['Permission']
                ], 403);
                
            }

        }else{
                
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
            ], 401);

        }
    }

    public function show($fonctions_id){

        $users = auth()->user();

        if($users){
            
            $fonctions = Fonctions::where('id',$fonctions_id)->first();

            if($fonctions){
                return response()->json([
                    'fonctions' => $fonctions
                ], 200);
            }else{
                
                return response()->json([
                    'message' => 'Cette fonction '.$this->constantes['NExistePasDansBD']
                ], 404);
            }
        }else{
                
            return response()->json([
                    'message' => $this->constantes['NonAuthentifier']
            ], 401);

        }
    }

    public function search($value){

        $user = auth()->user();

        if($user){
            
            $fonctions = Fonctions::where('nom_fonctions', 'like', "%$value%")->get();

            return response()->json([
                'fonctions' => $fonctions
            ], 200);
        }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
        ], 401);
        }
    }

    public function update(Request $request, $fonctions_id){
        $autorisation = false;

        $nom_fonctions = $request->nom_fonctions;

        $users = auth()->user();
        
        if($users){

            if($users->roles == "Administrateurs"){

                $fonctions_update = Fonctions::find($fonctions_id);

                if($fonctions_update){
    
                    $validator = Validator::make($request->all(), [
                            'nom_fonctions' => 'required|string',
                        ]);        
                        
                        if($validator->fails()){
                            
                            return response()->json([
                                'errors' => $validator->messages(),
                            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
                
                        }else{
                         
                            $verification_fonctions = DB::table('fonctions')
                                ->where('nom_fonctions', $nom_fonctions)
                                ->exists();
            
                            if($verification_fonctions){
            
                                $get_fonctions_existe = Fonctions::where('nom_fonctions', $nom_fonctions)->first();
                                
                                if($fonctions_update->id == $get_fonctions_existe->id){
                                    return response()->json([
                                        'message' => $this->constantes['PasDeChangement']
                                    ], 304);
                                }
            
                            }else{
                                $autorisation = true;
                            }

                            if($autorisation){

                                $fonctions_update->update([
                                    'nom_fonctions' => $nom_fonctions
                                ]);
                                
                                return response()->json([
                                    'message' => $this->constantes['Modification']
                                ], 200);

                            }else{
                                return response()->json([
                                    'message' => 'Cette fonction '.$this->constantes['ExisteDansBD']
                                ], 403);
                            }
                        }
                }else{
                    return response()->json([
                        'message' => 'Cette fonction '.$this->constantes['NExistePasDansBD']
                    ], 404);
                }
            }else{
                return response()->json([
                    'message' => $this->constantes['Permission']
                ], 403);
            }
        }else{
            return response()->json([
                    'message' => $this->constantes['NonAuthentifier']
            ], 401);
        }
    }

    public function delete($fonctions_id){

        $users = auth()->user();

        if($users){
            
            $fonctions = Fonctions::where('id',$fonctions_id)->first();

            if($fonctions){

                if($users->roles == "Administrateurs"){

                    $fonctions->delete();

                    return response()->json([
                        'message' => $this->constantes['Suppression']
                    ], 200); 

                }else{
                
                    return response()->json([
                        'message' => $this->constantes['Permission']
                    ], 403);

                }
                
            }else{
                
                return response()->json([
                    'message' => 'Cette fonction '.$this->constantes['NExistePasDansBD']
                ], 404);

            }

        }else{
                
            return response()->json([
                    'message' => $this->constantes['NonAuthentifier']
            ], 401);

        }
    }
}
