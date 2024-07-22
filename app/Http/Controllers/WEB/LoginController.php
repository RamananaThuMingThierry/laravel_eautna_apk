<?php

namespace App\Http\Controllers\WEB;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(){
        if(Auth::check()){
            if(Auth::check() && Auth::user()->status == false){
                return redirect()->route('status.not.approuved');
            }else{
                return redirect()->route('admin.membres.index');
            }
        }else{
            return View('auth.login');
        }
    }

    public function login(LoginRequest $request)
    {
        $data = $request->only('email', 'password');
        
        if (Auth::attempt($data)) {
            return response()->json([
                'success' => true, 
                'message' => 'Connection avec succès!'   
            ]);
        } else {
            return response()->json([
                'success' => false,
                'errors' => 'Ces informations d\'identification ne correspondent pas à nos enregistrements.'
            ]);
        }
    }
}
