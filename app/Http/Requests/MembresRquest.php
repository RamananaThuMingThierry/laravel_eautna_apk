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
            'image' => ['nullable', 'image','mimes:jpeg,png,jpg','max:4096'],
            'numero_carte' => ['required', 'numeric','min:1'],
            'nom' => ['required', 'string'],
            'prenom' => ['nullable', new UniqueNomEtPrenom($this->input('prenom'), $this->input('nom'), $membreId)],
            'date_de_naissance' => ['required', 'date', 'after_or_equal:1900-01-01', 'before_or_equal:today'],
            'lieu_de_naissance' => ['required', 'string'],
            'genre' => ['required'],
            'cin' => ['required', 'string', 'size:12', Rule::unique('membres')->ignore($membreId)], // 'size:12' assure que la taille de 'cin' est exactement de 12 caractères
            'adresse' => ['required', 'string'],
            'profession' => ['required'],
            'email' => ['nullable', 'email', Rule::unique('membres')->ignore($membreId)],
            'contact_personnel' => ['required', 'size:10', 'regex:/^0(32|33|34|38)\d{7}$/'],
            'contact_tuteur' => ['nullable', 'size:10', 'regex:/^0(32|33|34|38)\d{7}$/'],
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

    public function messages()
    {
        return [
            'image.image' => 'L\'image doit être une image.',
            'image.mimes' => 'L\'image doit être un fichier de type: jpeg, png, jpg.',
            'image.max' => 'L\'image ne peut pas dépasser 4096 kilooctets.',
            'numero_carte.required' => 'Le numéro de carte est obligatoire.',
            'numero_carte.numeric' => 'Le numéro de carte doit être un nombre.',
            'numero_carte.min' => 'Le numéro de carte doit être supérieur à 0.',
            'date_de_naissance.after_or_equal' => 'La date de naissance ne peut pas être antérieure à 1900.',
            'date_de_naissance.before_or_equal' => 'La date de naissance ne peut pas être postérieure à aujourd\'hui.',
            'nom.required' => 'Le nom est obligatoire.',
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'prenom.unique_nom_et_prenom' => 'La combinaison du prénom et du nom doit être unique.',
            'date_de_naissance.required' => 'La date de naissance est obligatoire.',
            'date_de_naissance.date' => 'La date de naissance doit être une date valide.',
            'lieu_de_naissance.required' => 'Le lieu de naissance est obligatoire.',
            'lieu_de_naissance.string' => 'Le lieu de naissance doit être une chaîne de caractères.',
            'genre.required' => 'Le genre est obligatoire.',
            'cin.required' => 'Le CIN est obligatoire.',
            'cin.string' => 'Le CIN doit être une chaîne de caractères.',
            'cin.size' => 'Le CIN doit avoir exactement 12 caractères.',
            'adresse.required' => 'L\'adresse est obligatoire.',
            'adresse.string' => 'L\'adresse doit être une chaîne de caractères.',
            'profession.required' => 'La profession est obligatoire.',
            'email.email' => 'L\'adresse e-mail doit être une adresse e-mail valide.',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée.',
            'contact_personnel.required' => 'Le contact personnel est obligatoire.',
            'contact_personnel.size' => 'Le contact personnel doit avoir exactement 10 chiffres.',
            'contact_personnel.regex' => 'Le contact personnel doit commencer par 032 ou 033 ou 034 ou 038.',
            'contact_tuteur.size' => 'Le contact du tuteur doit avoir exactement 10 chiffres.',
            'contact_tuteur.regex' => 'Le contact personnel doit commencer par 032 ou 033 ou 034 ou 038.',
            'facebook.string' => 'Le Facebook doit être une chaîne de caractères.',
            'date_inscription.required' => 'La date d\'inscription est obligatoire.',
            'date_inscription.date' => 'La date d\'inscription doit être une date valide.',
            'date_inscription.after_or_equal' => 'La date d\'inscription ne peut pas être antérieure à 1900.',
            'date_inscription.before_or_equal' => 'La date d\'inscription ne peut pas être postérieure à aujourd\'hui.',
            'axes_id.integer' => 'L\'axe doit être un nombre entier.',
            'filieres_id.integer' => 'La filière doit être un nombre entier.',
            'fonctions_id.integer' => 'La fonction doit être un nombre entier.',
            'levels_id.integer' => 'Le niveau doit être un nombre entier.',
            'sections_id.integer' => 'La section doit être un nombre entier.',
            'sympathisant.boolean' => 'La valeur du sympathisant doit être vraie ou fausse.',
        ];
    }
}
