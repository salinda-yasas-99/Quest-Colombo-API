<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\UserAuthMiddelware;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\WorkSpaceController;
use App\Http\Controllers\WorkSpaceSlotController;
use App\Http\Controllers\WorkSpaceTypeController;
use App\Models\WorkSpace;
use App\Models\WorkspaceType;

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

Route::get('api/packages', [PackageController::class, 'index']);
    //->middleware(UserAuthMiddelware::class); // Get all packages

Route::get('api/packages/{id}', [PackageController::class, 'show']);
    //->middleware(UserAuthMiddelware::class); // Get package by ID

Route::post('api/packages/', [PackageController::class, 'store']);
    //->middleware(UserAuthMiddelware::class); // Create a new package

Route::put('api/packages/{id}', [PackageController::class, 'update']);
    //->middleware(UserAuthMiddelware::class); // Update a package by ID
    
Route::delete('api/packages/{id}', [PackageController::class, 'destroy']);
    //->middleware(UserAuthMiddelware::class); // Delete a package by ID


//work space Types routes

Route::get('api/workSpaceTypes', [WorkSpaceTypeController::class, 'getAllWorkspaceTypes']);
    //->middleware(UserAuthMiddelware::class); // Get all Types


Route::post('api/workSpaceTypes', [WorkSpaceTypeController::class, 'createWorkspaceType']);
    //->middleware(UserAuthMiddelware::class); //add workspace


Route::delete('api/workSpaceTypes/{id}', [WorkSpaceTypeController::class, 'deleteTypeById']);
    //->middleware(UserAuthMiddelware::class); //delete type by id



//work space routes

Route::get('api/workSpaces', [WorkSpaceController::class, 'getAllWorkSpaces']);
    //->middleware(UserAuthMiddelware::class); // Get all workspaces

Route::get('api/workSpaces', [WorkSpaceController::class, 'getAllWorkSpacesByType']);
    //->middleware(UserAuthMiddelware::class); // Get all workspaces by type


Route::get('api/workSpacesByDate', [WorkSpaceController::class, 'getWorkspacesByTypeAndDate']);
    //->middleware(UserAuthMiddelware::class); // Get all workspaces


Route::post('api/workSpaces', [WorkSpaceController::class, 'AddNewWorkSpace']);
    //->middleware(UserAuthMiddelware::class); //add new workspace type

Route::delete('api/workSpaces/{id}', [WorkSpaceController::class, 'deleteWorkSpaceById']);
    //->middleware(UserAuthMiddelware::class); //delete workspace


//work space slot routes

Route::post('api/workSpacesSlots', [WorkSpaceSlotController::class, 'AddNewWorkSpaceSlot']);
    //->middleware(UserAuthMiddelware::class); //add new workspace type

