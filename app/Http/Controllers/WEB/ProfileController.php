<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateInfoProfileRequest;

class ProfileController extends Controller
{
    public function index(){
        if(Auth::check()){
            if(Auth::check() && Auth::user()->status == false){
                return redirect()->route('status.not.approuved');
            }else{
                return View('admin.profile.index',[
                    'user' => Auth::user()
                ]);
            }
        }else{
            return redirect()->route('login');
        }
       
    }

    public function updateInformation(UpdateInfoProfileRequest $request){
        if(Auth::check()){
            if(Auth::check() && Auth::user()->status == false){
                return redirect()->route('status.not.approuved');
            }else{
                $data = $request->only('pseudo','email','contact','adresse');
                Auth::user()->update($data);
                return response()->json([
                    'success' => true,
                    'message' => 'Votre information est à jours!'
                ]);
            }
        }else{
            return redirect(route('login'));
        }
    }
    
    public function updatePasswordProfile(UpdatePasswordRequest $request){
        if(Auth::check()){
            if(Auth::check() && Auth::user()->status == false){
                return redirect()->route('status.not.approuved');
            }else{
                $user = Auth::user();
                $validatedData = $request->validated();
                if(!Hash::check($validatedData['current_password'], $user->password)) {
                    return back()->with(['warning','Le mot de passe actuel est incorrect']);
                }
                $user->password = Hash::make($validatedData['password']);
                $user->save();
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return response()->json([
                    'success' => true,
                    'message' => 'Votre mot de passe a été bien modifier!'
                ]);
            }
        }else{
            return redirect(route('login'));
        }
    }


}
