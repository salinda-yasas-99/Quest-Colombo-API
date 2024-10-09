<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\UserAuthMiddelware;

// Registration route
Route::post('api/register', [AuthController::class, 'register']);

// Login route
Route::post('api/login', [AuthController::class, 'login']);



// get all users
Route::get('api/user', [UserController::class, 'getUsers'])
    ->middleware(AuthMiddleware::class); // Apply the custom middleware