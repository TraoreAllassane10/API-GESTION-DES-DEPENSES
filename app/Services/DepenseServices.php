<?php

namespace App\Services;

use App\Models\Depense;

class DepenseServices
{
    public function allDepense($page)
    {
        $parPage = 10;
        $offset = ($page - 1) * $parPage;

        return Depense::orderBy("date", "desc")->skip($offset)->take($parPage)->get();
    }

    public function createDepense($data)
    {
        $depense =  Depense::create($data);

        if (! $depense) {
            return response()->json([
                "success" => false,
                "status_code" => 401,
                "message" => "Erreur survenue lors de la création d'une depense",
            ]);;
        }

        return $depense;
    }

    public function findDepense($id)
    {
        // Si l'id n'est pas fourni
        if (! $id) {
            return response()->json([
                "success" => false,
                "status_code" => 400,
                "message" => "Vous devez fournir un identifiant",
            ]);
        }

        $depense = Depense::find($id);

        if (! $depense) {
            return response()->json([
                "success" => false,
                "status_code" => 404,
                "message" => "Depense introuvable",
            ]);
        }

        return $depense;
    }

    public function updateDepense($id, $data)
    {

        // Recupereration de la depense à modifer
        $depense = $this->findDepense($id);

        // Mise à jour de la dépense
        $depense->update([
            "description" => $data["description"],
            "montant" => $data["montant"],
            "date" => $data["date"] ?? $data["date"],
            "user_id" => $data["user_id"]
        ]);

        return $depense;
    }

    public function destroyDepense($id)
    {
        // Recupereration de la depense à supprimer
        $depense = $this->findDepense($id);

        $depense->delete();

        return $depense;
    }
}
