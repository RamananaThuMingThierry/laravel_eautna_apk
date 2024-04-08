<?php

namespace App\Models;

use App\Models\Level;
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
        "etablissement",
        "contact_personnel",
        "contact_tuteur",
        "sympathisant",
        "fonctions_id",
        "filieres_id",
        "levels_id",
        "sections_id",
        "adresse",
        "date_inscription",
        "facebook",
        "axes_id",
    ];
}
