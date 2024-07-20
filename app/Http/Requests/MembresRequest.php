<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Rules\UniqueNomEtPrenom;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Http\FormRequest;

class MembresRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $id = $this->route('membre');
        Log::info("Identifiant membre : ". $id);
        
        // $membreId = $encryptedId == null ? null : Crypt::decryptString($encryptedId);

        return [
            'photo' => ['nullable', 'image','mimes:jpeg,png,jpg','max:4096'],
            'numero_carte' => ['required', 'numeric','min:1'],
            'nom' => ['required', 'string'],
            'prenom' => ['nullable', new UniqueNomEtPrenom($this->input('prenom'), $this->input('nom'), $id)],
            'date_de_naissance' => ['required', 'date', 'after_or_equal:1900-01-01', 'before_or_equal:today'],
            'lieu_de_naissance' => ['required', 'string'],
            'genre' => ['required'],
            'cin' => ['nullable', 'string', 'size:12', Rule::unique('membres')->ignore($id)], 
            'adresse' => ['required', 'string'],
            'profession' => ['required','string'],
            'etablissement' => ['nullable','string'],
            'email' => ['nullable', 'email', Rule::unique('membres')->ignore($id)],
            'contact_personnel' => ['required', 'size:10', 'regex:/^0(32|33|34|37|38)\d{7}$/'],
            'contact_tuteur' => ['required', 'size:10', 'regex:/^0(32|33|34|37|38)\d{7}$/'],
            'facebook' => ['nullable', 'string'],
            'date_inscription' => ['required', 'date','after_or_equal:2013-01-01', 'before_or_equal:today'],
            'axes_id' => ['nullable', 'integer'],
            'filieres_id' => ['nullable', 'integer'],
            'fonctions_id' => ['nullable', 'integer'],
            'levels_id' => ['nullable', 'integer'],
            'sections_id' => ['nullable', 'integer'],
            'sympathisant' => ['boolean'],
        ];
    }
  
    public function messages(): array
    {
        return [
            'photo.image' => 'Le fichier doit être une image.',
            'photo.mimes' => 'L\'image doit être au format jpeg, png, ou jpg.',
            'photo.max' => 'L\'image ne doit pas dépasser 4MB.',
            'numero_carte.required' => 'Le numéro de carte est obligatoire.',
            'numero_carte.numeric' => 'Le numéro de carte doit être un nombre.',
            'numero_carte.min' => 'Le numéro de carte doit être supérieur à 0.',
            'nom.required' => 'Le nom est obligatoire.',
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'prenom.nullable' => 'Le prénom est facultatif.',
            'date_de_naissance.required' => 'La date de naissance est obligatoire.',
            'date_de_naissance.date' => 'La date de naissance doit être une date valide.',
            'date_de_naissance.after_or_equal' => 'La date de naissance doit être après le 1er janvier 1900.',
            'date_de_naissance.before_or_equal' => 'La date de naissance doit être aujourd\'hui ou avant.',
            'lieu_de_naissance.required' => 'Le lieu de naissance est obligatoire.',
            'lieu_de_naissance.string' => 'Le lieu de naissance doit être une chaîne de caractères.',
            'genre.required' => 'Le genre est obligatoire.',
            'cin.nullable' => 'La carte d\'identité nationale est facultative.',
            'cin.string' => 'La carte d\'identité nationale doit être une chaîne de caractères.',
            'cin.size' => 'La carte d\'identité nationale doit être de 12 caractères.',
            'cin.unique' => 'Cette carte d\'identité nationale est déjà utilisée.',
            'adresse.required' => 'L\'adresse est obligatoire.',
            'adresse.string' => 'L\'adresse doit être une chaîne de caractères.',
            'profession.required' => 'La profession est obligatoire.',
            'profession.string' => 'La profession doit être une chaîne de caractères.',
            'etablissement.nullable' => 'L\'établissement est facultatif.',
            'etablissement.string' => 'L\'établissement doit être une chaîne de caractères.',
            'email.nullable' => 'L\'adresse email est facultative.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'contact_personnel.required' => 'Le contact personnel est obligatoire.',
            'contact_personnel.size' => 'Le contact personnel doit être de 10 caractères.',
            'contact_personnel.regex' => 'Le contact personnel doit commencer par 032, 033, 034, 037 ou 038 suivi de 7 chiffres.',
            'contact_personnel.required' => 'Le contact en cas d\'urgence est obligatoire.',
            'contact_tuteur.nullable' => 'Le contact tuteur est facultatif.',
            'contact_tuteur.size' => 'Le contact tuteur doit être de 10 caractères.',
            'contact_tuteur.regex' => 'Le contact tuteur doit commencer par 032, 033, 034, 037 ou 038 suivi de 7 chiffres.',
            'facebook.nullable' => 'Le Facebook est facultatif.',
            'facebook.string' => 'Le Facebook doit être une chaîne de caractères.',
            'date_inscription.required' => 'La date d\'inscription est obligatoire.',
            'date_inscription.date' => 'La date d\'inscription doit être une date valide.',
            'date_inscription.after_or_equal' => 'La date d\'inscription doit être après le 1er janvier 2013.',
            'date_inscription.before_or_equal' => 'La date d\'inscription doit être aujourd\'hui ou avant.',
            'axes_id.nullable' => 'L\'axe est facultatif.',
            'axes_id.integer' => 'L\'axe doit être un nombre entier.',
            'filieres_id.nullable' => 'La filière est facultative.',
            'filieres_id.integer' => 'La filière doit être un nombre entier.',
            'fonctions_id.nullable' => 'La fonction est facultative.',
            'fonctions_id.integer' => 'La fonction doit être un nombre entier.',
            'levels_id.nullable' => 'Le niveau est facultatif.',
            'levels_id.integer' => 'Le niveau doit être un nombre entier.',
            'sections_id.nullable' => 'La section est facultative.',
            'sections_id.integer' => 'La section doit être un nombre entier.',
            'sympathisant.boolean' => 'Le champ sympathisant doit être vrai ou faux.',
        ];
    }

}
