<?php

namespace App\Http\Controllers;

use App\Models\feedBack;
use Exception;
use Illuminate\Http\Request;

class FeedBackController extends Controller
{
    public function getAllFeedbacks()
    {
        try {
            $feedbacks = feedBack::all();
            return response()->json($feedbacks, 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve feedbacks',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Post a new feedback.
     */
    public function postFeedback(Request $request)
    {
        try {
           
            $feedback = feedBack::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => "unread"
            ]);

            return response()->json([
                'message' => 'Feedback submitted successfully',
                'data' => $feedback
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to submit feedback',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteFeedback($id)
    {
        try {
            $feedback = feedBack::findOrFail($id);
            //$feedback->delete();

            $feedback->status = "read";

            $feedback->save();

            return response()->json([
                'message' => 'Feedback status updated successfully'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to update feedback',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
