<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBorneRequest extends FormRequest
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
            'nom' => 'required|string|max:255',
            'localisation' => 'required|string',
            'type_connecteur' => 'required|in:Type1,Type2',
            'puissance_kw' => 'required|numeric|min:1',
        ];
    }

    public function messages():array
    {
        return [
            'nom.required' => 'nom est obligatoire',
            'localisation.required' => "localisation est obligatoire",
            'type_connecteur.required' => 'type de connecteur est obligatoire',
            'puissance_kw.required' => 'puissance est obligatoire',
        ];
    }
}
