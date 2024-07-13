<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Level extends Model
{
    use HasFactory, SoftDeletes;
    
    public $table = "levels";

    protected $fillable = [
        "nom_niveau",
    ];

    protected $dates = ['deleted_at'];
     
    public function membres(){
        return $this->hasMany(Membres::class);
    }
}
