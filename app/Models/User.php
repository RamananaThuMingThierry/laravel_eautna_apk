<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Axes;
use App\Models\Post;
use App\Models\Level;
use App\Models\Membres;
use App\Models\Filieres;
use App\Models\Messages;
use App\Models\Fonctions;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $table = "users";

    protected $fillable = [
        'pseudo',
        "image",
        "contact",
        "adresse",
        "roles",
        "status",
        'email',
        'mot_de_passe',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'mot_de_passe' => 'hashed',
    ];
}
