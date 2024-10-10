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
    ->middleware(UserAuthMiddelware::class); // Apply the custom middleware

// Get a single user by ID
Route::get('api/user/{id}', [UserController::class, 'getUserById']);
    //->middleware(AuthMiddleware::class);
    
// Delete a user by ID
Route::delete('api/user/{id}', [UserController::class, 'deleteUser']);
    //->middleware(AuthMiddleware::class); 