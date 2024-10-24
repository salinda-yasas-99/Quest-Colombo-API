<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FeedBackController;
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

//send email
Route::post('api/send-email', [AuthController::class, 'sendEmail']);

//send email
Route::post('api/otp', [AuthController::class, 'sendOtp']);

//send email
Route::post('api/reset-password', [AuthController::class, 'resetPassword']);


// get all users
Route::get('api/user', [UserController::class, 'getUsers'])
    -> middleware(UserAuthMiddelware::class); // Apply the custom middleware

// get all users
Route::get('api/users/byStatus', [UserController::class, 'getUsersByStatus'])
    -> middleware(UserAuthMiddelware::class); 

// Get a single user by ID
Route::get('api/user/{id}', [UserController::class, 'getUserById'])
    ->middleware(UserAuthMiddelware::class);
    
// Delete a user by ID
Route::delete('api/user/{id}', [UserController::class, 'deleteUser'])
    ->middleware(AuthMiddleware::class); 


// Routes for Packages

Route::get('api/packages', [PackageController::class, 'index'])
    ->middleware(UserAuthMiddelware::class); // Get all packages

Route::get('api/packages/{id}', [PackageController::class, 'show'])
    ->middleware(UserAuthMiddelware::class); // Get package by ID

Route::post('api/packages/', [PackageController::class, 'store'])
    ->middleware(AuthMiddleware::class); // Create a new package

Route::put('api/packages/{id}', [PackageController::class, 'update'])
    ->middleware(AuthMiddleware::class); // Update a package by ID
    
Route::delete('api/packages/{id}', [PackageController::class, 'destroy'])
    ->middleware(AuthMiddleware::class); // Delete a package by ID


//work space Types routes

Route::get('api/workSpaceTypes', [WorkSpaceTypeController::class, 'getAllWorkspaceTypes'])
    ->middleware(UserAuthMiddelware::class); //Get all Types


Route::post('api/workSpaceTypes', [WorkSpaceTypeController::class, 'createWorkspaceType'])
    ->middleware(AuthMiddleware::class); //add workspace

Route::put('api/workSpaceTypes/edit/{id}', [WorkSpaceTypeController::class, 'updateWorkSpace'])
    ->middleware(AuthMiddleware::class); //update workspace


Route::delete('api/workSpaceTypes/{id}', [WorkSpaceTypeController::class, 'deleteTypeById'])
    ->middleware(AuthMiddleware::class); //delete type by id



//work space routes

Route::get('api/workSpaces', [WorkSpaceController::class, 'getAllWorkSpaces'])
    ->middleware(UserAuthMiddelware::class); // Get all workspaces

Route::get('api/workSpaces', [WorkSpaceController::class, 'getAllWorkSpacesByType'])
    ->middleware(UserAuthMiddelware::class); // Get all workspaces by type


Route::get('api/workSpacesByDate', [WorkSpaceController::class, 'getWorkspacesByTypeAndDate'])
    ->middleware(UserAuthMiddelware::class); // Get all workspaces

Route::get('api/workSpacesByDateIdType', [WorkSpaceController::class, 'getWorkspacesbyDateTypeId'])
    ->middleware(UserAuthMiddelware::class); // Get all workspaces


Route::post('api/workSpaces', [WorkSpaceController::class, 'AddNewWorkSpace'])
    ->middleware(AuthMiddleware::class); //add new workspace type

Route::delete('api/workSpaces/{id}', [WorkSpaceController::class, 'deleteWorkSpaceById'])
    ->middleware(AuthMiddleware::class); //delete workspace


//work space slot routes

Route::post('api/workSpacesSlots', [WorkSpaceSlotController::class, 'AddNewWorkSpaceSlot'])
    ->middleware(AuthMiddleware::class); //add new workspace type





//booking routes

Route::post('api/bookings', [BookingController::class, 'createBooking'])
    ->middleware(UserAuthMiddelware::class); //add booking

Route::get('api/bookings/all', [BookingController::class, 'getAllBookings'])
    ->middleware(AuthMiddleware::class); //get all bookings 

Route::get('api/bookings/user/{userId}', [BookingController::class, 'getBookingsByUserId'])
    ->middleware(UserAuthMiddelware::class); //get bookings by user id

Route::get('api/bookings/payment', [BookingController::class, 'getBookingsByPaymentStatus'])
    ->middleware(AuthMiddleware::class); //get booking by payment atatus

Route::put('api/bookings/updatePayment/{bookingId}', [BookingController::class, 'updatePaymentStatus'])
    ->middleware(AuthMiddleware::class); //update booking payment status to paid


//feedback routes

Route::get('api/feedbacks', [FeedBackController::class, 'getAllFeedbacks'])
    ->middleware(AuthMiddleware::class); //get all feedback

Route::post('api/feedback', [FeedBackController::class, 'postFeedback']);

Route::delete('api/feedback/{id}', [FeedBackController::class, 'deleteFeedback'])
    ->middleware(AuthMiddleware::class); //delete feedback by id