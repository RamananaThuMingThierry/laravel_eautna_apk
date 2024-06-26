<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\Axes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use DragonCode\Contracts\Cashier\Http\Response;

class AxesController extends Controller
{
    public function index(){
       
       $user = auth()->user();

       if($user){

            $axes = Axes::orderBy('nom_axes')->get();

            return Response()->json([
                'axes' => $axes
            ], 200);
       }else{
           return Response()->json([
            'message' =>  $this->constantes['NonAuthentifier']
           ], 401);
       }

    }

    public function search($value){
        
        $user = auth()->user();

        if($user){
            
            $axes = Axes::where('nom_axes', 'like', "%$value%")->get();

            return response()->json([
                'axes' => $axes
            ], 200);
        }else{
            return response()->json([
                'message' => $this->constantes['NonAuthentifier']
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
                        'nom_axes' => $nom_axes
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

    public function show($axes_id){
        
        $user = auth()->user();

        if($user){
            
            $axes = Axes::where('id',$axes_id)->first();

            if($axes){
                return response()->json([
                    'axes' => $axes
                ], 200);
            }else{
                
                return response()->json([
                    'message' => 'Cet axes '.$this->constantes['NExistePasDansBD']
                ], 404);
            }

        }else{
                
            return response()->json([
                    'message' => $this->constantes['NonAuthentifier']
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
                                        'message' => $this->constantes['PasDeChangement']
                                    ], 304);
                                }
            
                            }else{
                                $autorisation = true;
                            }

                            if($autorisation){

                                $axes->update([
                                    'nom_axes' => $nom_axes
                                ]);
                                
                                return response()->json([
                                    'message' => $this->constantes['Modification']
                                ], 200);

                            }else{
                                return response()->json([
                                    'message' => 'Cet axes '.$this->constantes['ExisteDansBD']
                                ], 403);
                            }
                        }
                }else{
                    return response()->json([
                        'message' => 'Cet axes '.$this->constantes['NExistePasDansBD']
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

    public function delete($axes_id){
        
        $users = auth()->user();

        if($users){
            
            $axes = Axes::where('id',$axes_id)->first();

            if($axes){

                if($users->roles == "Administrateurs"){

                    $axes->delete();

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
                    'message' => 'Cet axes '.$this->constantes['NExistePasDansBD']
                ], 404);

            }

        }else{
                
            return response()->json([
                    'message' => $this->constantes['NonAuthentifier']
            ], 401);

        }
    }
}
