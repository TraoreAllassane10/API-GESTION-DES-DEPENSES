<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\AuthServices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthControlleur extends Controller
{

    private $authServices;
    private $user;

    public function __construct(AuthServices $authServices)
    {
        $this->authServices = $authServices;
        $this->user = Auth::user();
    }

    public function register(RegisterRequest $request)
    {
        try {
            // Validation des données
            $data = $request->validated();

            // Creationn de l'utilisateur
            $user = $this->authServices->createUser($data);

            // Si l'inscription echoue
            if (! $user) {
                return response()->json([
                    "success" => false,
                    "status_code" => 400,
                    "message" => "Erreur survenue lors de la creation de l'utilisateur",
                ]);
            }

            return response()->json([
                "success" => true,
                "status_code" => 201,
                "message" => "Utilisateur crée",
                "data" => [
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Erreur survenue au niveau du serveur",
                "errors" => $e->getMessage()
            ]);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            // Validation des données
            $data = $request->validated();

            // Authentification de l'utlisateur de recupération de ses infos ainsi que son token
            $response = $this->authServices->authUser($data);
            $user = $response["user"];
            $token = $response['token'];
       
            // Si l'authentification echoue
            if (! $user) {
                return response()->json([
                    "success" => false,
                    "status_code" => 400,
                    "message" => "email ou mot de passe incorrect",
                ]);
            }

            return response()->json([
                "success" => true,
                "status_code" => 200,
                "message" => "Utilisateur connecté",
                "token" => $token,
                "data" => [
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Erreur survenue au niveau du serveur",
                "errors" => $e->getMessage()
            ]);
        }
    }
}
