<?php

namespace App\Http\Controllers;

use App\Models\WorkspaceType;
use Exception;
use Illuminate\Http\Request;

class WorkSpaceTypeController extends Controller
{
    // POST: Create a new workspace type
    public function createWorkspaceType(Request $request)
    {
        try {
           
            // Create a new workspace type
            $workspaceType = new WorkspaceType();
            $workspaceType->type_name = $request->input('typename');
            $workspaceType->save();

            // Return success response
            return response()->json([
                'message' => 'Workspace type successfully created!',
                'workspaceType' => $workspaceType
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to create workspace type',
                'message' => $e->getMessage()
            ], 500);
        }
    }

     // GET: Retrieve all workspace types
     public function getAllWorkspaceTypes()
     {
         try {
             
             $workspaceTypes = WorkspaceType::all();
 
             // Return success response
             return response()->json($workspaceTypes, 200);
 
         } catch (Exception $e) {
             // Handle any errors
             return response()->json([
                 'error' => 'Failed to retrieve workspace types',
                 'message' => $e->getMessage()
             ], 500);
         }
     }


     //delete work space by id
     public function deleteTypeById($id)
    {
        // Find the user by ID
        $workspaceType = WorkspaceType::find($id);

        // Check if the user exists
        if (!$workspaceType) {
            return response()->json(['error' => 'Type not found'], 404);
        }

        // Delete the user
        $workspaceType->delete();

        // Return success message
        return response()->json(['message' => 'Work Space Type deleted successfully']);
    }
}
