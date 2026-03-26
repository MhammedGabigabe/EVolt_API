<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'borne_id' => 'required|exists:bornes,id',
            'date_debut' => 'required|date|after_or_equal:now',
            'duree_minutes' => 'required|integer|min:15',
        ];
    }

    public function messages(): array
    {
        return [
            'borne_id.required' => 'La borne est obligatoire',
            'borne_id.exists' => 'Cette borne n\'existe pas',
            'date_debut.required' => 'L\'heure de début est obligatoire',
            'date_debut.after_or_equal' => 'La date de début doit être aujourd\'hui ou plus tard',
            'duree_minutes.required' => 'La durée est obligatoire',
            'duree_minutes.min' => 'La durée minimale est de 15 minutes',
        ];
    }
}
