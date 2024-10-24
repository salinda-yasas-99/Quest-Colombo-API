<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
      // Registration method
    public function register(Request $request)
    {
       

        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            // If user exists, return an error response
            return response()->json([
                'error' => 'A user with this email already exists'
            ], 400);
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,  // Password will be encrypted automatically
            'role' => $request->role,
            'status' =>"active",
            'points'=>0,
            'tiar'=>"platinum"
        ]);

        // Generate JWT token for the registered user
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
            'token' => $token,  
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

         // Check if the user's status is deactivated
        if ($user->status !== 'active') {
                return response()->json(['message' => 'Your account is deactivated. Please contact support.'], 403);
        }

         // Generate JWT token for the registered user
         $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,  // Return the token
        ]);
    }


    public function sendEmail(Request $request)
    {
        try {
            // Validate request data
            $request->validate([
                'to' => 'required|email',
                'subject' => 'required|string',
                'message' => 'required|string',
            ]);

            // Send the email
            Mail::to($request->to)->send(new SendEmail($request->subject, $request->message));

            // Return a success response
            return response()->json(['message' => 'Email sent successfully'], 200);
        } catch (\Exception $e) {
            // Catch any errors and return a failure response
            return response()->json([
                'error' => 'An error occurred while sending the email',
                'message' => $e->getMessage()
            ], 500);
        }
    }

      // Method to send OTP for password reset
      public function sendOtp(Request $request)
      {
          try {
            
            //   $request->validate([
            //       'email' => 'required|email|exists:user,email',
            //   ]);
  
              $otp = rand(100000, 999999);
  
              Cache::put('otp_' . $request->email, $otp, now()->addMinutes(3));

              Mail::to($request->email)->send(new sendEmail('Password Reset OTP', "Your OTP is $otp. It expires in 3 minutes."));
  
             
              return response()->json(['message' => 'OTP sent successfully'], 200);
  
          } catch (\Exception $e) {
              return response()->json(['error' => 'Failed to send OTP', 'message' => $e->getMessage()], 500);
          }
      }
  
      public function resetPassword(Request $request)
    {
        try {
        
            $cachedOtp = Cache::get('otp_' . $request->email);
            if (!$cachedOtp || $cachedOtp != $request->otp) {
                return response()->json(['error' => 'Invalid or expired OTP'], 400);
            }

            $user = User::where('email', $request->email)->first();
            
            $user->password = $request->new_password; 

            $user->save();

            Cache::forget('otp_' . $request->email);

            return response()->json(['message' => 'Password reset successfully'], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to reset password', 'message' => $e->getMessage()], 500);
        }
    }



}
