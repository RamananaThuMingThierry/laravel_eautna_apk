<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'pseudo' => ['required', 'string', 'max:100'],
            'email' => ['required','email','string','max:255','unique:users'],
            'contact' =>  ['required','size:10','regex:/^0(32|33|34|37|38)\d{7}$/'],
            'adresse' => ['required','string'],
            'password' => ['required','string','min:8']
        ];
    }

    public function messages(): array
    {
        return [
            'pseudo.required' => 'Le pseudo est obligatoire.',
            'pseudo.string' => 'Le pseudo doit être une chaîne de caractères.',
            'pseudo.max' => 'Le pseudo ne peut pas dépasser 100 caractères.',
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email doit être une adresse email valide.',
            'email.string' => 'L\'email doit être une chaîne de caractères.',
            'email.max' => 'L\'email ne peut pas dépasser 255 caractères.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'contact.required' => 'Le contact est obligatoire.',
            'contact.size' => 'Le contact doit contenir exactement 10 chiffres.',
            'contact.regex' => 'Le contact doit commencer par 032, 033, 034, 037 ou 038 et être suivi de 7 chiffres.',
            'adresse.required' => 'L\'adresse est obligatoire.',
            'adresse.string' => 'L\'adresse doit être une chaîne de caractères.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.'
        ];
    }
}
