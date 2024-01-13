<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fonctions extends Model
{
    use HasFactory;

    public $table = "fonctions";

    protected $fillable = [
        "fonctions",
        "users_id",
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }
}
