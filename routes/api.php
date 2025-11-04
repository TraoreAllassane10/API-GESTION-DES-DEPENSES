<?php

use App\Http\Controllers\Api\AuthControlleur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthControlleur::class)->group(function() {
    Route::post("/register", "register")->name("user.register");
    Route::post("/login", "login")->name("user.login");
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
