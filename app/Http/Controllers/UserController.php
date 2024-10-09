<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsers(Request $request){
         // Get the 'role' query parameter
    $role = $request->query('role');

    $users = User::where('role', $role)->get();
    
    // Return the users as a JSON response
    return response()->json($users);
    }
}
