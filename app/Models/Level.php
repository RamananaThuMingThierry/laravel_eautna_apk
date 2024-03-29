<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    
    public $table = "levels";

    protected $fillable = [
        "niveau",
        "users_id"
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }
}
