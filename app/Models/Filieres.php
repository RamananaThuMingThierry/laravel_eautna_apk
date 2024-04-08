<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filieres extends Model
{
    use HasFactory;
    
    public $table = "filieres";

    protected $fillable = [
        "nom_filieres"
    ];
}
