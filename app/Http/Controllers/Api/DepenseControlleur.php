<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\DepenseResource;

use App\Services\DepenseServices;
use App\Http\Controllers\Controller;
use App\Http\Requests\Depense\CreateDepenseRequest;
use App\Http\Requests\Depense\UpdateDepenseRequest;
use Exception;


class DepenseControlleur extends Controller
{
    private $depenseServices;

    public function __construct(DepenseServices $depenseServices)
    {
        $this->depenseServices = $depenseServices;
    }

    public function index()
    {
        try {
            $depenses = $this->depenseServices->allDepense();

            return response()->json([
                "success" => true,
                "status_code" => 200,
                "message" => "Liste des depenses",
                "data" => DepenseResource::collection($depenses)
            ]);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "status_code" => 500,
                "message" => "Erreur survenue au niveau du serveur",
                "errors" => $e->getMessage()
            ]);;
        }
    }


    public function store(CreateDepenseRequest $request)
    {
        try {
            // Validation des données
            $data = $request->validated();
            $data['user_id'] = $request->user()->id;

            // Création d'une depense
            $depense = $this->depenseServices->createDepense($data);

            return response()->json([
                "success" => true,
                "status_code" => 200,
                "message" => "Depense crée",
                "data" => new DepenseResource($depense)
            ]);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "status_code" => 500,
                "message" => "Erreur survenue au niveau du serveur",
                "errors" => $e->getMessage()
            ]);;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $depense = $this->depenseServices->findDepense($id);

            return response()->json([
                "success" => true,
                "status_code" => 200,
                "message" => "Une Depense trouvée",
                "data" => new DepenseResource($depense)
            ]);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "status_code" => 500,
                "message" => "Erreur survenue au niveau du serveur",
                "errors" => $e->getMessage()
            ]);;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepenseRequest $request, string $id)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = $request->user()->id;

            $depense = $this->depenseServices->updateDepense($id, $data);

            return response()->json([
                "success" => true,
                "status_code" => 200,
                "message" => "Depense modifiée",
                "data" => $depense
            ]);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "status_code" => 500,
                "message" => "Erreur survenue au niveau du serveur",
                "errors" => $e->getMessage()
            ]);;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->depenseServices->destroyDepense($id);

            return response()->json([
                "success" => true,
                "status_code" => 200,
                "message" => "Depense supprimée",

            ]);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "status_code" => 500,
                "message" => "Erreur survenue au niveau du serveur",
                "errors" => $e->getMessage()
            ]);;
        }
    }
}
