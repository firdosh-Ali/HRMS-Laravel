<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;


Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('logout',[AuthController::class,'logout']);

    Route::get('/user',[UserController::class,'show']);
    Route::get('/all-users',[UserController::class,'allusers']);
    Route::put('users/{id}', [UserController::class,'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});


