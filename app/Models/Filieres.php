<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Filieres extends Model
{
    use HasFactory, SoftDeletes;
    
    public $table = "filieres";

    protected $fillable = [
        "nom_filieres"
    ];

    protected $dates = ['deleted_at'];
     
    public function membres(){
        return $this->hasMany(Membres::class);
    }
}
