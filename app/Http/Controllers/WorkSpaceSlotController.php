<?php

namespace App\Http\Controllers;

use App\Models\WorkSpaceSlot;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkSpaceSlotController extends Controller
{
    // POST: Create a new workspace
    public function AddNewWorkSpaceSlot(Request $request): JsonResponse
    {
        try {
            

            // Create a new workspace
            $workspaceSlot = WorkSpaceSlot::create([
                'date' => $request->date,
                'slot_1' => $request->slot_1,
                'slot_2' => $request->slot_2,
                'slot_3' => $request->slot_3,
                'workspace_id' => $request->workspace_id
            ]);

            // Return the created workspace and success message
            return response()->json([
                'message' => 'Workspace slot successfully created',
                'workspace' => $workspaceSlot,
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
}
