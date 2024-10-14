<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsers(Request $request)
    {
        // Get the 'role' query parameter, default to 'all' if not provided
        $role = $request->query('role', 'all');

        // Fetch users based on the role
        if ($role === 'all') {
            // If role is 'all', get all users
            $users = User::all();
        } else {
            // Otherwise, filter users by the specified role
            $users = User::where('role', $role)->get();
        }
        
        // Return the users as a JSON response
        return response()->json($users);
    }


    public function getUserById($id)
    {
        // Find the user by ID
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Return the user as a JSON response
        return 
        response()->json($user);
    }

    public function deleteUser($id)
    {
        // Find the user by ID
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Delete the user
        $user->delete();

        // Return success message
        return response()->json(['message' => 'User deleted successfully']);
    }





}
