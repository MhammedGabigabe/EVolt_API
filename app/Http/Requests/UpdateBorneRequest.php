<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBorneRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user() && auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => 'sometimes|string|max:255',
            'localisation' => 'sometimes|string',
            'type_connecteur' => 'sometimes|in:Type1,Type2',
            'puissance_kw' => 'sometimes|numeric|min:1',
            'statut' => 'sometimes|in:disponible,occupee,maintenance',
        ];
    }

    public function messages(): array
    {
        return [
            'nom.string' => 'Le nom doit être une chaîne de caractères',
            'type_connecteur.in' => 'Type de connecteur invalide',
            'puissance_kw.numeric' => 'La puissance doit être un nombre',
            'statut.in' => 'Statut invalide',
        ];
    }
}
