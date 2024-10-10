<?php

namespace App\Http\Controllers;

use App\Models\WorkSpace;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkSpaceController extends Controller
{
     // GET: Retrieve all workspaces
     public function getAllWorkSpaces(): JsonResponse
     {
         try {
             // Attempt to retrieve all workspaces with their associated workspace type
             $workspaces = WorkSpace::with('workspaceType')->get();
 
             // Return the retrieved workspaces
             return response()->json($workspaces, 200);
         } catch (Exception $e) {
             // If something goes wrong, return an error message with a 500 status code
             return response()->json([
                 'error' => 'Failed to retrieve workspaces',
                 'message' => $e->getMessage()
             ], 500);
         }
     }

     public function getAllWorkSpacesByType(Request $request): JsonResponse
    {
        try {
            // Get the 'type_name' query parameter if it exists
            $typeName = $request->query('type_name');
            
            // Check if 'type_name' is provided, if so, filter workspaces by type name
            if ($typeName) {
                // Retrieve workspaces filtered by workspace type name
                $workspaces = WorkSpace::whereHas('workspaceType', function ($query) use ($typeName) {
                    $query->where('type_name', $typeName);
                })->with('workspaceType')->get();
            } else {
                // Retrieve all workspaces with their associated workspace type
                $workspaces = WorkSpace::with('workspaceType')->get();
            }

            // Return the retrieved workspaces
            return response()->json($workspaces, 200);
        } catch (Exception $e) {
            // If something goes wrong, return an error message with a 500 status code
            return response()->json([
                'error' => 'Failed to retrieve workspaces',
                'message' => $e->getMessage()
            ], 500);
        }
    }

 
     // POST: Create a new workspace
     public function AddNewWorkSpace(Request $request): JsonResponse
     {
         try {
             
 
             // Create a new workspace
             $workspace = WorkSpace::create([
                 'name' => $request->name,
                 'description' => $request->description,
                 'location' => $request->location,
                 'fee' => $request->fee,
                 'imageUrl' => $request->imageUrl,
                 'workspace_type_id' => $request->workspace_type_id,
             ]);
 
             // Return the created workspace and success message
             return response()->json([
                 'message' => 'Workspace successfully created',
                 'workspace' => $workspace,
             ], 201);
         } catch (\Illuminate\Validation\ValidationException $e) {
             // Handle validation errors
             return response()->json([
                 'error' => 'Validation error',
                 'message' => $e->errors(),
             ], 422);
         } catch (Exception $e) {
             // Catch any other exceptions and return a 500 error
             return response()->json([
                 'error' => 'Failed to create workspace',
                 'message' => $e->getMessage()
             ], 500);
         }
     }

       //delete work space by id
       public function deleteWorkSpaceById($id)
       {
           // Find the user by ID
           $workspace = WorkSpace::find($id);
   
           // Check if the user exists
           if (!$workspace) {
               return response()->json(['error' => 'WorkSpace not found'], 404);
           }
   
           // Delete the user
           $workspace->delete();
   
           // Return success message
           return response()->json(['message' => 'Work Space deleted successfully']);
       }
}
