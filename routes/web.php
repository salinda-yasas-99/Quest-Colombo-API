<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Registration route
Route::post('/register', [AuthController::class, 'register']);

// Login route
Route::post('/login', [AuthController::class, 'login']);