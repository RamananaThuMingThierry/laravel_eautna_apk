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
}
