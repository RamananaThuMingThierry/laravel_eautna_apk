<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Rules\UniqueNomEtPrenom;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Http\FormRequest;

class MembresRquest extends FormRequest
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
        $encryptedId = $this->route('membre'); // Assurez-vous que la route utilise {membre} comme paramètre
        $membreId = $encryptedId == null ? null : Crypt::decryptString($encryptedId);

        return [
            'photo' => ['nullable', 'image'],
            'numero_carte' => ['required', 'numeric'],
            'nom' => ['required', 'string'],
            'prenom' => ['nullable', new UniqueNomEtPrenom($this->input('prenom'), $this->input('nom'), $membreId)],
            'date_de_naissance' => ['required', 'date'],
            'lieu_de_naissance' => ['required', 'string'],
            'genre' => ['required'],
            'cin' => ['required', 'string', 'size:12'], // 'size:12' assure que la taille de 'cin' est exactement de 12 caractères
            'adresse' => ['required', 'string'],
            'profession' => ['required'],
            'email' => ['nullable', 'email', Rule::unique('membres')->ignore($membreId)],
            'contact_personnel' => ['required', 'numeric'],
            'contact_tuteur' => ['nullable', 'numeric'],
            'facebook' => ['nullable', 'string'],
            'date_inscription' => ['required', 'date'],
            'axes_id' => ['nullable', 'integer'],
            'filieres_id' => ['nullable', 'integer'],
            'fonctions_id' => ['nullable', 'integer'],
            'levels_id' => ['nullable', 'integer'],
            'sections_id' => ['nullable', 'integer'],
            'sympathisant' => ['boolean'],
        ];
    }

    public function messages()
    {
        return [
            'photo.image' => 'Le fichier doit être une image.',
            'numero_carte.required' => 'Le numéro de carte est obligatoire.',
            'numero_carte.numeric' => 'Le numéro de carte doit être un nombre.',
            'nom.required' => 'Le nom est obligatoire.',
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'date_de_naissance.required' => 'La date de naissance est obligatoire.',
            'date_de_naissance.date' => 'La date de naissance doit être une date valide.',
            'lieu_de_naissance.required' => 'Le lieu de naissance est obligatoire.',
            'lieu_de_naissance.string' => 'Le lieu de naissance doit être une chaîne de caractères.',
            'genre.required' => 'Le genre est obligatoire.',
            'cin.required' => 'Le champ CIN est obligatoire.',
            'cin.string' => 'Le champ CIN doit être une chaîne de caractères.',
            'cin.size' => 'Le champ CIN doit avoir exactement :size caractères.',
            'adresse.required' => 'L\'adresse est obligatoire.',
            'adresse.string' => 'L\'adresse doit être une chaîne de caractères.',
            'profession.required' => 'La profession est obligatoire.',
            'email.email' => 'L\'email doit être une adresse email valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'contact_personnel.required' => 'Le contact personnel est obligatoire.',
            'contact_personnel.numeric' => 'Le contact personnel doit être un nombre.',
            'contact_tuteur.numeric' => 'Le contact du tuteur doit être un nombre.',
            'facebook.string' => 'Le lien Facebook doit être une chaîne de caractères.',
            'date_inscription.required' => 'La date d\'inscription est obligatoire.',
            'date_inscription.date' => 'La date d\'inscription doit être une date valide.',
            'axes_id.integer' => 'L\'ID des axes doit être un nombre entier.',
            'filieres_id.integer' => 'L\'ID des filières doit être un nombre entier.',
            'fonctions_id.integer' => 'L\'ID des fonctions doit être un nombre entier.',
            'levels_id.integer' => 'L\'ID des niveaux doit être un nombre entier.',
            'sections_id.integer' => 'L\'ID des sections doit être un nombre entier.',
            'sympathisant.boolean' => 'Le champ sympathisant doit être un booléen.',
        ];
    }
}
