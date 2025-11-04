<?php

use App\Http\Controllers\Api\AuthControlleur;
use App\Http\Controllers\Api\DepenseControlleur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthControlleur::class)->group(function () {
    Route::post("/register", "register")->name("user.register");
    Route::post("/login", "login")->name("user.login");
});



Route::middleware('auth:sanctum')->group(function () {
    Route::controller(DepenseControlleur::class)->group(function () {
        Route::get("/depenses", "index")->name("depense.index");
        Route::post("/depenses", "store")->name("depense.store");
        Route::get("/depenses/{depense}", "show")->name("depense.show");
        Route::put("/depenses/{depense}", "update")->name("depense.update");
        Route::delete("/depenses/{depense}", "destroy")->name("depense.destroy");
    });
});
