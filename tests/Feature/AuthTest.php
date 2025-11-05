<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use function Pest\Laravel\{postJson, get};

test("Un utlisateur peut s'inscrire", function() {
    $response = $this->postJson("/api/register", [
        "name" => "Allassane",
        "email" => "allassane@gmail.com",
        "password" => "password"
    ]);

    $response->assertStatus(200);
});


test("Un utilisateur peut se connecter", function () {
    $user = User::factory()->create([
        "password" => Hash::make("password")
    ]);
   
    $response = $this->postJson("/api/login", [
        "email" => $user->email,
        "password" => "password"
    ]);

    $response->assertStatus(200);
});
