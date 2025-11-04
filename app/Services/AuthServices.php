<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthServices
{
    public function createUser($data)
    {
        // Hachage du mot de passe
        $motDePasseHache = Hash::make($data["password"], [PASSWORD_DEFAULT]);

        return User::create([
            "name" => $data['name'],
            "email" => $data['email'],
            "password" => $motDePasseHache,
        ]);
    }

    public function authUser($data)
    {
        if (Auth::attempt($data)) {
            
            $user = Auth::user();

            //Creation du jeton APi (token)
            $token = $user->createToken(env("CLE_SECRETE"))->plainTextToken;

            return [
                "user" => $user,
                "token" => $token
            ];
        }
    }
}
