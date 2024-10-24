<?php

namespace App\Http\Controllers;

use App\Models\WorkSpace;
use App\Models\WorkspaceType;
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

    public function getWorkspacesByTypeAndDate(Request $request): JsonResponse
    {
        try {
            // Retrieve query parameters for workspace type and date
            $workspaceTypeName = $request->query('workspace_type');
            $date = $request->query('date'); // Assuming the date is in yyyy-mm-dd format


            // Get workspace type ID based on the name
            $workspaceType = WorkspaceType::where('type_name', $workspaceTypeName)->first();

            if (!$workspaceType) {
                return response()->json([
                    'error' => 'Invalid workspace_type provided'
                ], 404);
            }

            // Retrieve workspaces of the given type and slots based on the date
            $workspaces = WorkSpace::with(['workspaceType', 'workspaceSlots' => function ($query) use ($date) {
                $query->where('date', $date);
            }])
            ->where('workspace_type_id', $workspaceType->id)
            ->get();

            // Format the response
            $formattedWorkspaces = $workspaces->map(function ($workspace) {
                return [
                    'id' => $workspace->id,
                    'name' => $workspace->name,
                    'description' => $workspace->description,
                    'location' => $workspace->location,
                    'fee' => $workspace->fee,
                    'imageUrl' => $workspace->imageUrl,
                    'workspace_type_id' => $workspace->workspace_type_id,
                    'workspace_type' => [
                        'id' => $workspace->workspaceType->id,
                        'type_name' => $workspace->workspaceType->type_name,
                    ],
                    // Assuming that workspace has one slot on a specific date
                    'slot_1' => $workspace->workspaceSlots->isNotEmpty() ? $workspace->workspaceSlots->first()->slot_1 : 'available',
                    'slot_2' => $workspace->workspaceSlots->isNotEmpty() ? $workspace->workspaceSlots->first()->slot_2 : 'available',
                    'slot_3' => $workspace->workspaceSlots->isNotEmpty() ? $workspace->workspaceSlots->first()->slot_3 : 'available',
                ];
            });

            // Return the formatted response
            return response()->json($formattedWorkspaces, 200);

        } catch (Exception $e) {
            // If something goes wrong, return an error message with a 500 status code
            return response()->json([
                'error' => 'Failed to retrieve workspaces',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getWorkspacesbyDateTypeId(Request $request)
    {
        try {
            // Retrieve query parameters for workspace type, date, and workspace ID
            $workspaceTypeName = $request->query('workspace_type');
            $date = $request->query('date'); // Assuming the date is in yyyy-mm-dd format
            $workspaceId = $request->query('workspace_id'); // New query parameter for workspace ID
    
            // Get workspace type ID based on the name
            $workspaceType = WorkspaceType::where('type_name', $workspaceTypeName)->first();
    
            if (!$workspaceType) {
                return response()->json([
                    'error' => 'Invalid workspace_type provided'
                ], 404);
            }
    
            // Retrieve workspaces of the given type and slots based on the date
            $query = WorkSpace::with(['workspaceType', 'workspaceSlots' => function ($query) use ($date) {
                $query->where('date', $date);
            }])
            ->where('workspace_type_id', $workspaceType->id);
    
            // If workspace_id is provided, get the specific workspace
            if ($workspaceId) {
                $workspace = $query->find($workspaceId);
    
                if (!$workspace) {
                    return response()->json([
                        'error' => 'Workspace not found'
                    ], 404);
                }
            } else {
                // If no workspace_id is provided, get the first matching workspace
                $workspace = $query->first();
    
                if (!$workspace) {
                    return response()->json([
                        'error' => 'No workspace available for the specified criteria'
                    ], 404);
                }
            }
    
            // Format the response for a single workspace
            $formattedWorkspace = [
                'id' => $workspace->id,
                'name' => $workspace->name,
                'description' => $workspace->description,
                'location' => $workspace->location,
                'fee' => $workspace->fee,
                'imageUrl' => $workspace->imageUrl,
                'workspace_type_id' => $workspace->workspace_type_id,
                'workspace_type' => [
                    'id' => $workspace->workspaceType->id,
                    'type_name' => $workspace->workspaceType->type_name,
                ],
                // Assuming that workspace has one slot on a specific date
                'slot_1' => $workspace->workspaceSlots->isNotEmpty() ? $workspace->workspaceSlots->first()->slot_1 : 'available',
                'slot_2' => $workspace->workspaceSlots->isNotEmpty() ? $workspace->workspaceSlots->first()->slot_2 : 'available',
                'slot_3' => $workspace->workspaceSlots->isNotEmpty() ? $workspace->workspaceSlots->first()->slot_3 : 'available',
            ];
    
            // Return the formatted response for a single workspace
            return response()->json($formattedWorkspace, 200);
    
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

     public function updateWorkSpace(Request $request, $id): JsonResponse
    {
        try {
            // Find the workspace by ID
            $workspace = WorkSpace::find($id);

            // Check if the workspace exists
            if (!$workspace) {
                return response()->json(['error' => 'Workspace not found'], 404);
            }

            // Update the workspace fields
            $workspace->update([
                'name' => $request->name,
                'description' => $request->description,
                'location' => $request->location,
                'fee' => $request->fee,
                'imageUrl' => $request->imageUrl,
                'workspace_type_id' => $request->workspace_type_id,
            ]);

            // Return the updated workspace and success message
            return response()->json([
                'message' => 'Workspace successfully updated',
                'workspace' => $workspace,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'error' => 'Validation error',
                'message' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            // Catch any other exceptions and return a 500 error
            return response()->json([
                'error' => 'Failed to update workspace',
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
