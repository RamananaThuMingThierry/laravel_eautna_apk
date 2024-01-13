<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    use HasFactory;
    
    public $table = "commentaires";

    protected $fillable = [
        "niveau",
        "users_id"
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }
}
