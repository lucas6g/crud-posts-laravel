<?php


use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;




Route::get('/user', [UserController::class, 'show'])->middleware("requireAuth");

Route::post('/user', [UserController::class, 'create']);

Route::post('/session',[AuthController::class,'login']);


