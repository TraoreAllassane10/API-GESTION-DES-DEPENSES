<?php

use App\Models\Depense;
use App\Models\User;
use function Pest\Laravel\{postJson, get};

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user, "sanctum");
});

test("un utilisateur peut voir toutes les depenses", function () {
    $response = $this->get("/api/depenses");

    $response->assertOk();
    $response->assertStatus(200);
});

test("Un utilisateur peut creer une depense", function () {
    $response = $this->postJson("/api/depenses", [
        "description" => "Depense de test",
        "montant" => 100000
    ]);

    $response->assertOk();
    $response->assertStatus(200);
});

test("Un utilisateur peut voir une depense donné", function () {

    $depense = Depense::factory()->create([
        "description" => "Depense de test",
        "montant" => 100000,
        "user_id" => $this->user->id
    ]);

    $response = $this->get("/api/depenses/{$depense->id}");

    $response->assertOk();
    $response->assertStatus(200);
});

test("Un utilisateur peut modifier une depense", function () {
    $depense = Depense::factory()->create([
        "description" => "Depense de test",
        "montant" => 100000,
        "user_id" => $this->user->id
    ]);

    $response = $this->putJson("/api/depenses/{$depense->id}", [
        "description" => "Depense de test modifié",
        "montant" => 200000,
        "user_id" => $this->user->id
    ]);

    $response->assertOk()->assertStatus(200);
});

test("Un utilisateur peut supprimer une depense", function () {
    $depense = Depense::factory()->create([
        "description" => "Depense de test",
        "montant" => 100000,
        "user_id" => $this->user->id
    ]);

    $response = $this->delete("/api/depenses/{$depense->id}");

    $response->assertOk()->assertStatus(200);
});
