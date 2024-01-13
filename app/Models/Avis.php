<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    use HasFactory;

    public $table = "avis";

    protected $fillable = [
        "message",
        "users_id"
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }
}
