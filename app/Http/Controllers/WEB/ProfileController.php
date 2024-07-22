<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
