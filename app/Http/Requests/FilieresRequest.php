<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class FilieresRequest extends FormRequest
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
            'nom_filieres' => [
                'required',
                'string',
                'max:100',
                Rule::unique('filieres')->ignore($this->route('filiere'))->whereNull('deleted_at')
            ]
        ];
    }

    public function messages()
    {
        return [
            'nom_filieres.required' => 'Le champ nom des filières est obligatoire.',
            'nom_filieres.string' => 'Le champ nom des filières doit être une chaîne de caractères.',
            'nom_filieres.max' => 'Le champ nom des filières ne peut pas dépasser 100 caractères.',
            'nom_filieres.unique' => 'Ce nom de filière est déjà utilisé. Veuillez choisir un autre nom unique.'
        ];
    }
}
