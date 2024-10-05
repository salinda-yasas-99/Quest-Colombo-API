<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
      // Registration method
    public function register(Request $request)
    {
        // $request->validate([
        //     'username' => 'required|string|max:255|unique:users',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:8',
        //     'role' => 'required|in:admin,user'
        // ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,  // Password will be encrypted automatically
            'role' => $request->role,
        ]);

        // Generate JWT token for the registered user
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
            'token' => $token,  // Return the token
        ]);
    }


    // Login method
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt to authenticate the user
        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        // Get the authenticated user
        $user = Auth::user();

         // Generate JWT token for the registered user
         $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,  // Return the token
        ]);
    }


}
