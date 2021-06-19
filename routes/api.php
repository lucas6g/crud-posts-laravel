<?php


use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ListUserPostsController;

use App\Http\Controllers\Api\PostController;


Route::post('/user', [UserController::class, 'create']);

Route::post('/session', [AuthController::class, 'login']);

Route::post('/post', [PostController::class, 'create'])->middleware("requireAuth");

Route::get('/post', [PostController::class, 'index'])->middleware("requireAuth");

Route::get('/post/{id}/edit', [PostController::class, 'edit'])->middleware("requireAuth");

Route::put('/post/{id}/update', [PostController::class, 'update'])->middleware("requireAuth");

Route::delete('/post/{id}/delete', [PostController::class, 'delete'])->middleware("requireAuth");

Route::get("/post/me", [ListUserPostsController::class, 'index'])->middleware('requireAuth');
