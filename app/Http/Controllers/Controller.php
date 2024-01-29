<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public $constantes;

    public function __construct()
    {
        $this->constantes = app('constants');
    }

    public function verifierNumeroTelephone($numero){
        return (bool) preg_match('/^(032|033|034|038)/', $numero);
    }

    public function saveImage($image, $path = 'public'){
        
        if(!$image) return null;

        $filename = time().'.png';

        // Save Image
        Storage::disk($path)->put($filename, base64_decode($image));

        // return the path
        // url is the base url exp: localhost:8000
        return URL::to('/').'/storage/'.$path.'/'.$filename;
    }
}
