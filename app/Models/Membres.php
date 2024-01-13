<?php

namespace App\Models;

use App\Models\Niveau;
use App\Models\Filieres;
use App\Models\Fonctions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Membres extends Model
{
    use HasFactory;

    public $table = "membres";

    protected $fillable = [
        "image",
        "numero_carte",
        "nom",
        "prenom",
        "date_de_naissance",
        "lieu_de_naissance",
        "cin",
        "genre",
        "contact_personnel",
        "contact_tutaire",
        "sympathisant",
        "fonctions_id",
        "filieres_id",
        "niveau_id",
        "adresse",
        "users_membre_id",
        "facebook",
        "axes_id",
        "users_id",
        "commentaires"
    ];

    public function fonctions(){
        return $this->hasMany(Fonctions::class);
    }

    public function filieres(){
        return $this->hasMany(Filieres::class);
    }
    
    public function niveau(){
        return $this->hasMany(Niveau::class);
    }

    public function axes(){
        return $this->hasMany(Axes::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }
}
