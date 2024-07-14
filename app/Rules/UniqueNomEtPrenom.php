<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Membres;

class UniqueNomEtPrenom implements ValidationRule
{
    protected $prenom;
    protected $nom;
    protected $ignoreId;

    public function __construct($prenom, $nom, $ignoreId = null)
    {
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->ignoreId = $ignoreId;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Vérifier si la combinaison nom et prénom est unique dans la base de données
        $query = Membres::where('nom', $this->nom)->where('prenom', $this->prenom);

        if ($this->ignoreId) {
            $query->where('id', '==', $this->ignoreId);
        }

        if ($query->exists()) {
            $fail('La combinaison nom et prénom doit être unique.');
        }
    }
}
