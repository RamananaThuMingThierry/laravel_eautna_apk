<?php

namespace App\Models;

use App\Models\Commentaires;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    
    public $table = "posts";

    protected $fillable = [
        "image",
        "description",
        "date",
        "users_id"
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function likes(){
        return $this->hasMany(Likes::class);
    }

    public function commentaires(){
        return $this->hasMany(Commentaires::class);
    }
}
