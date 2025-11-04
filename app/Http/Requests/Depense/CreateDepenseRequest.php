<?php

namespace App\Http\Requests\Depense;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateDepenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "success" => false,
            "status_code" => 400,
            "message" => "Erreur de validation",
            "errors" => $validator->errors()
        ]));
    }

    public function rules(): array
    {
        return [
            "description" => ["required", "string"],
            "montant" => ["required", "numeric"],
            "date" => ["nullable"],
        ];
    }

    public function messages()
    {
        return [
            "description.required" => "La description est requis",
            "description.string" => "La description doit etre une chaine de caractère",
            "montant.required" => "Le montant est requis",
            "montant.numeric" => "Le montant doit etre un entier",
        ];
    }
}
