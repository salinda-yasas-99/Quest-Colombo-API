<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\UserAuthMiddelware;
use App\Http\Controllers\PackageController;

// Registration route
Route::post('api/register', [AuthController::class, 'register']);

// Login route
Route::post('api/login', [AuthController::class, 'login']);


// get all users
Route::get('api/user', [UserController::class, 'getUsers']) -> middleware(AuthMiddleware::class); // Apply the custom middleware

// Get a single user by ID
Route::get('api/user/{id}', [UserController::class, 'getUserById']);
    //->middleware(AuthMiddleware::class);
    
// Delete a user by ID
Route::delete('api/user/{id}', [UserController::class, 'deleteUser']);
    //->middleware(AuthMiddleware::class); 


// Routes for Packages
Route::get('api/packages', [PackageController::class, 'index'])
    ->middleware(UserAuthMiddelware::class); // Get all packages

Route::get('api/packages/{id}', [PackageController::class, 'show'])
    ->middleware(UserAuthMiddelware::class); // Get package by ID

Route::post('api/packages/', [PackageController::class, 'store'])
    ->middleware(UserAuthMiddelware::class); // Create a new package

Route::put('api/packages/{id}', [PackageController::class, 'update'])
    ->middleware(UserAuthMiddelware::class); // Update a package by ID
    
Route::delete('api/packages/{id}', [PackageController::class, 'destroy'])
    ->middleware(UserAuthMiddelware::class); // Delete a package by ID


