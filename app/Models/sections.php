<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class sections extends Model
{
    use HasFactory, SoftDeletes;

    public $table = "sections";

    protected $fillable = [
        "nom_sections"
    ];

    protected $dates = ['deleted_at'];
     
    public function membres(){
        return $this->hasMany(Membres::class);
    }
}
