<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgetPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return View('auth.forget_password');
    }
}
