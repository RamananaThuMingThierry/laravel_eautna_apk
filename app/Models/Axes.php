<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Axes extends Model
{
    use HasFactory, SoftDeletes;

    public $table = "axes";

    protected $fillable = [
        "nom_axes"
    ];

    protected $dates = ['deleted_at'];
     
    public function membres(){
        return $this->hasMany(Membres::class);
    }
}
