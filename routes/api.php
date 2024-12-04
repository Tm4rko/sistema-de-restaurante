<?php

use App\Http\Controllers\Api\JsonController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [UserController::class,'register']);
Route::post('login', [UserController::class,'login']);

Route::group(['middleware'=>["auth:sanctum"]],function(){
    Route::get('logout', [UserController::class,'logout']);
    Route::post('categorias', [JsonController::class,'categorias']);
    Route::post('productos', [JsonController::class,'productos']);
    // Añadir la ruta para obtener los pedidos del usuario 
    Route::post('pedidos', [JsonController::class,'pedidos']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
