<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    public function index(){
       
        $user = auth()->user();
 
        if($user){
             $sections = sections::orderBy('nom_sections')->get();
 
             return Response()->json([
                 'sections' => $sections
             ], 200);
        }else{
            return Response()->json([
             'message' =>  $this->constantes['NonAuthentifier']
            ], 401);
        }
 
     }

     public function show($sections_id){
        
        $user = auth()->user();

        if($user){
            
            $sections = sections::where('id',$sections_id)->first();

            if($sections){
                return response()->json([
                    'sections' => $sections
                ], 200);
            }else{
                
                return response()->json([
                    'message' => 'Cette sections '.$this->constantes['NExistePasDansBD']
                ], 404);
            }

        }else{
                
            return response()->json([
                    'message' => $this->constantes['NonAuthentifier']
            ], 401);

        }
    }
 
}
