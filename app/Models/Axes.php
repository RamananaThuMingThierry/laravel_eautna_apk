<?php

namespace App\Models;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Axes extends Model
{
    use HasFactory;

    public $table = "axes";

    protected $fillable = [
        "nom_axes"
    ];
}
