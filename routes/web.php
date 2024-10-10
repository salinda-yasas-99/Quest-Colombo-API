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
Route::get('api/packages', [PackageController::class, 'index'])->middleware(AuthMiddleware::class); // Get all packages
Route::get('api/packages/{id}', [PackageController::class, 'show']); // Get package by ID
Route::post('api/packages/', [PackageController::class, 'store']); // Create a new package
Route::put('api/packages/{id}', [PackageController::class, 'update']); // Update a package by ID
Route::delete('api/packages/{id}', [PackageController::class, 'destroy']); // Delete a package by ID


