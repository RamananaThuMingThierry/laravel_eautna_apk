<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class NiveauRequest extends FormRequest
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
            'nom_niveau' => [
                'required',
                'string',
                'max:100',
                Rule::unique('levels')->ignore($this->route('niveau'))->whereNull('deleted_at')
            ]
        ];
    }

    public function messages()
    {
        return [
            'nom_niveau.required' => 'Le champ nom du niveau est obligatoire.',
            'nom_niveau.string' => 'Le champ nom du niveau doit être une chaîne de caractères.',
            'nom_niveau.max' => 'Le champ nom du niveau ne peut pas dépasser 100 caractères.',
            'nom_niveau.unique' => 'Ce nom de niveau est déjà utilisé. Veuillez choisir un autre nom unique.'
        ];
    }
}
