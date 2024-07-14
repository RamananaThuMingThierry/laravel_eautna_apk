<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class FonctionsRequest extends FormRequest
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
        return [
            'nom_fonctions' => [
                'required',
                'string',
                'max:100',
                Rule::unique('fonctions')->ignore($this->route('fonctions'))->whereNull('deleted_at')
            ]
        ];
    }

    public function messages()
    {
        return [
            'nom_fonctions.required' => 'Le champ nom du fonction est obligatoire.',
            'nom_fonctions.string' => 'Le champ nom du fonction doit être une chaîne de caractères.',
            'nom_fonctions.max' => 'Le champ nom du fonction ne peut pas dépasser 100 caractères.',
            'nom_fonctions.unique' => 'Ce nom de fonction est déjà utilisé. Veuillez choisir un autre nom unique.'
        ];
    }
}
