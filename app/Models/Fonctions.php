<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fonctions extends Model
{
    use HasFactory, SoftDeletes;

    public $table = "fonctions";

    protected $fillable = [
        "nom_fonctions"
    ];

    protected $dates = ['deleted_at'];
     
    public function membres(){
        return $this->hasMany(Membres::class);
    }
}
