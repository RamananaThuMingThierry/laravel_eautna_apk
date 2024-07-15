<?php

namespace App\Models;

use App\Models\Level;
use App\Models\Filieres;
use App\Models\Fonctions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Membres extends Model
{
    use HasFactory, SoftDeletes;

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
        'email',
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

    // La colonne qui enregistrera la date de suppression
    protected $dates = ['deleted_at'];

    public function filiere(){
        return $this->belongsTo(Filieres::class, 'filieres_id');
    }
    
    public function fonction(){
        return $this->belongsTo(Fonctions::class, 'fonctions_id');
    }

    public function level(){
        return $this->belongsTo(Level::class, 'levels_id');
    }

    public function axes(){
        return $this->belongsTo(Axes::class, 'axes_id');
    }

    public function section(){
        return $this->belongsTo(Sections::class, 'sections_id');
    }

    protected $casts = [
        'sympathisant' => 'boolean'
    ];
}
