<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Exception;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthMiddleware
{
  
    //public function AuthorizeAdmin(Request $request, Closure $next, $role): Response
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Parse the token from the Authorization header
            $token = $request->bearerToken();
    
            if (!$token) {
                return response()->json(['error' => 'Authorization token not found'], 401);
            }
    
            $decodedToken = JWTAuth::setToken($token)->getPayload();  
    
            // Retrieve the 'uid' (or whatever field you included in the JWT custom claims)
            $uid = $decodedToken->get('uid');
            
            // Find the user by 'uid'
            $user = User::find($uid);
    
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
    
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token has expired'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        } catch (Exception $e) {
            return response()->json(['error' =>  $e->getMessage()], 401);
        }
    
        // Check if the user's role matches the required role
        if ($user->role !== "admin") {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }
    
        return $next($request);
    }

    // public function AuthorizeAdminAndUser(Request $request, Closure $next, $role): Response
    // {
    //     try {
            
    //         $token = JWTAuth::parseToken();  
    //         $decodedToken = JWTAuth::getPayload($token);  

    //         // Retrieve the 'uid' (or whatever field you included in the JWT custom claims)
    //         $uid = $decodedToken->get('uid');
            
    //         // Find the user by 'uid'
    //         $user = User::find($uid);

    //         if (!$user) {
    //             return response()->json(['error' => 'User not found'], 404);
    //         }

    //     } catch (TokenExpiredException $e) {
    //         return response()->json(['error' => 'Token has expired'], 401);
    //     } catch (TokenInvalidException $e) {
    //         return response()->json(['error' => 'Invalid token'], 401);
    //     } catch (Exception $e) {
    //         return response()->json(['error' => 'Authorization token not found'], 401);
    //     }

    //     // Check if the user's role matches the required role
    //     if ($user->role === "admin" || $user->role === "user" ) {
    //         return response()->json(['error' => 'Unauthorized access'], 403);
    //     }

    //     return $next($request);
    // }
}
