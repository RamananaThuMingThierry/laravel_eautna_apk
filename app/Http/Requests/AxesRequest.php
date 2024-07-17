<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;

class AxesRequest extends FormRequest
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
        $id = $this->route('axe'); // Récupère l'ID de l'axe de la route

        return [
            'nom_axes' => [
                'required',
                'string',
                'max:100',
                Rule::unique('axes')->ignore($id, 'id')->whereNull('deleted_at')
            ]
        ];
    }
    
    public function messages()
    {
        return [
            'nom_axes.required' => 'Le champ nom axes est obligatoire.',
            'nom_axes.string' => 'Le champ nom axes doit être une chaîne de caractères.',
            'nom_axes.max' => 'Le champ nom axes ne peut pas dépasser 100 caractères.',
            'nom_axes.unique' => 'Ce nom est déjà utilisé. Veuillez choisir un autre nom unique.'
        ];
    }


}
