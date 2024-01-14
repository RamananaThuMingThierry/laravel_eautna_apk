<?php

namespace App\Http\Controllers;

use App\Models\Membres;
use Illuminate\Http\Request;

class MembresController extends Controller
{
    public function index(){

        $membres = Membres::orderBy('numero_carte')->with('users:id,pseudo,image')->get();

        return response()->json([
            'membres' => $membres
        ]);

    }


}
