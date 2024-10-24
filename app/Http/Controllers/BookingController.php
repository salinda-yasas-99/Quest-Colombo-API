<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\WorkSpaceSlot;
use Exception;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Stripe;

class BookingController extends Controller
{
    public function createBooking(Request $request)
    {
        try {

            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            // Retrieve the userId from query parameter
            $userId = $request->query('userId');
            if (!$userId) {
                return response()->json(['error' => 'User ID is required'], 400);
            }

              // Create Stripe charge
              $charge = Charge::create([
                'amount' =>$request->totalCharges * 100, // Amount in cents
                'currency' => 'LKR',
                'description' => 'Workspace Booking',
                'source' => $request->stripeToken,
                'metadata' => ['user_id' => $userId],
            ]);
    
            // Check if the workspace slot exists for the booked date and workspace ID
            $workspaceSlot = WorkSpaceSlot::where('date', $request->bookedDate)
                ->where('workspace_id', $request->workspace_id)
                ->first();
    
            // If workspace slot exists, update the relevant slot, otherwise create a new record
            if ($workspaceSlot) {
                // Check which slot needs to be updated
                if ($workspaceSlot[$request->bookedSlot] === 'available') {
                    $workspaceSlot->update([$request->bookedSlot => 'booked']);
                } else {
                    return response()->json(['error' => 'The selected slot is already booked'], 400);
                }
            } else {
                // Create a new workspace slot and update the booked slot
                WorkSpaceSlot::create([
                    'date'         => $request->bookedDate,
                    'workspace_id' => $request->workspace_id,
                    'slot_1'       => $request->bookedSlot == 'slot_1' ? 'booked' : 'available',
                    'slot_2'       => $request->bookedSlot == 'slot_2' ? 'booked' : 'available',
                    'slot_3'       => $request->bookedSlot == 'slot_3' ? 'booked' : 'available',
                ]);
            }

           
    
            // Create the booking record
            $booking = Booking::create([
                'totalCharges'   => $request->totalCharges,
                'bookedDate'     => $request->bookedDate,
                'bookedTime'     => $request->bookedTime,
                'paymentMethod'  => $request->paymentMethod,
                'paymentStatus'  => $request->paymentStatus,
                'bookedSlot'     => $request->bookedSlot,
                'startTime'      => $request->startTime,
                'endTime'        => $request->endTime,
                'user_id'        => $userId,
                'workspace_id'   => $request->workspace_id,
                'package_id'     => $request->package_id,
                'stripeChargeId' => $charge->id

            ]);

            $user = User::find($userId);
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $user->points += 100;
            $user->save();
            $tier_Details = $request->tier; 

            // Check if tier is present in the request
            if ($tier_Details == null) {
                return response()->json(['message' => 'Booking created successfully', 'booking' => $booking], 201);
            }
            elseif($tier_Details == 'silver'){
                $user->points -= 3000; 
                $user->save();
            }
            elseif($tier_Details == 'gold'){
                $user->points -= 5000; 
                $user->save();
            }
    
            // Return a success response with the booking data
            return response()->json(['message' => 'Booking created successfully', 'booking' => $booking], 201);
    
        } catch (\Exception $e) {
            // Catch any exceptions and return an error response
            return response()->json([
                'error' => 'An error occurred while creating the booking',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllBookings()
    {
        try {
            // Retrieve bookings by user ID and eager load related models
            $bookings = Booking::with(['user', 'workspace', 'package'])->get();

            // Check if bookings exist
            // if ($bookings->isEmpty()) {
            //     return response()->json(['message' => 'No bookings found for the given user ID'], 404);
            // }

            // Return the list of bookings with related details
            return response()->json($bookings, 200);

        } catch (\Exception $e) {
            // Catch any errors and return a 500 error response with the exception message
            return response()->json([
                'error' => 'An error occurred while retrieving bookings',
                'message' => $e->getMessage()
            ], 500);
        }
    }

     // Method to get bookings by user ID
     public function getBookingsByUserId($userId)
    {
        try {
            // Retrieve bookings by user ID and eager load related models
            $bookings = Booking::with(['user', 'workspace', 'package'])->where('user_id', $userId)->get();

            // Check if bookings exist
            // if ($bookings->isEmpty()) {
            //     return response()->json(['message' => 'No bookings found for the given user ID'], 404);
            // }

            // Return the list of bookings with related details
            return response()->json($bookings, 200);

        } catch (\Exception $e) {
            // Catch any errors and return a 500 error response with the exception message
            return response()->json([
                'error' => 'An error occurred while retrieving bookings',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getBookingsByPaymentStatus(Request $request)
    {
        try {
            // Retrieve the paymentStatus from the query parameter
            $paymentStatus = $request->query('paymentStatus');
    
            // Validate the payment status (ensure it's either "Paid" or "Pending")
            if (!in_array($paymentStatus, ['Paid', 'Pending'])) {
                return response()->json(['error' => 'Invalid payment status. It must be either "Paid" or "Pending".'], 400);
            }
    
            // Retrieve bookings based on the payment status and eager load related models
            $bookings = Booking::with(['user', 'workspace', 'package'])
                ->where('paymentStatus', $paymentStatus)
                ->get();
    
            // Check if bookings exist for the given payment status
            // if ($bookings->isEmpty()) {
            //     return response()->json(['message' => "No bookings found with payment status: $paymentStatus"], 404);
            // }
    
            // Return the list of bookings with related details
            return response()->json($bookings, 200);
    
        } catch (\Exception $e) {
            // Catch any errors and return a 500 error response with the exception message
            return response()->json([
                'error' => 'An error occurred while retrieving bookings',
                'message' => $e->getMessage()
            ], 500);
        }
    }

     // Method to update paymentStatus to "Paid" by booking ID
     public function updatePaymentStatus(Request $request, $bookingId)
     {
         try {
             // Find the booking by ID
             $booking = Booking::find($bookingId);
 
             // Check if booking exists
             if (!$booking) {
                 return response()->json(['error' => 'Booking not found'], 404);
             }
 
             // Update payment status to "Paid"
             $booking->paymentStatus = 'Paid';
             $booking->save();
 
             // Return a success response with the updated booking
             return response()->json(['message' => 'Payment status updated successfully', 'booking' => $booking], 200);
         
         } catch (Exception $e) {
             // Catch any errors and return a 500 error response with the exception message
             return response()->json([
                 'error' => 'An error occurred while updating the payment status',
                 'message' => $e->getMessage()
             ], 500);
         }
     }
    
}
