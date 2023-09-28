<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(["middleware" => "web"], function (){
    Route::post("login", [UserController::class, 'login']);
    Route::get("logout", [UserController::class, 'logout']);
});

Route::get("users", [UserController::class, 'index']);
Route::get("users/{id}", [UserController::class, 'show']);
Route::post("users", [UserController::class, 'store']);
Route::put("users/{id}", [UserController::class, 'update']);
Route::delete("users/{id}", [UserController::class, 'drop']);
