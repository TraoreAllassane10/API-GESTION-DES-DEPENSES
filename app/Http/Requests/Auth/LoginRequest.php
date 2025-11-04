<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            "email" => ["required", "email"],
            "password" => ["required", "min:4"]
        ];
    }

     public function messages()
    {
        return [
            "email.required" => "L'email de l'utilisateur est requis",
            "email.email" => "Enter un email valide",
            "password.required" => "Le mot de passe est requis",
            "password.min" => "Le mot de passe doit contenir au moins 4 caractère",
        ];
    }
}
