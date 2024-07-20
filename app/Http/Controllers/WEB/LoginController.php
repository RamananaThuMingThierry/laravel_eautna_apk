<?php

namespace App\Http\Controllers\WEB;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(){
        return View('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $data = $request->only('email', 'password');
        
        if (Auth::attempt($data)) {
            $user = Auth::user();
            $request->session()->regenerate();
            if($user->status == false){
                return response()->json(['success' => true, 'redirect_url' => route('status.not.approuved')]);
            }else{
                return response()->json(['success' => true, 'redirect_url' => route('admin.membres.index')]);
            }
        } else {
            return response()->json([
                'success' => false,
                'errors' => 'Ces informations d\'identification ne correspondent pas à nos enregistrements.'
            ]);
        }
    }
}
