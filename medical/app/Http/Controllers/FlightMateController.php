<?php

namespace App\Http\Controllers;

use App\Models\FlightMate;
use App\Models\FlightMateBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FlightMateController extends Controller
{
    public function index()
    {
        $flightMates = FlightMate::join('medical_users', 'flight_mates.user_id', '=', 'medical_users.user_id')
            ->select('flight_mates.*', 'medical_users.first_name', 'medical_users.last_name')
            ->where('flight_mates.is_available', true)
            ->get();
        
        $myBookings = FlightMateBooking::join('flight_mates', 'flight_mate_bookings.flight_mate_id', '=', 'flight_mates.id')
            ->join('medical_users', 'flight_mates.user_id', '=', 'medical_users.user_id')
            ->where('flight_mate_bookings.user_id', Auth::user()->user_id)
            ->select('flight_mate_bookings.*', 'medical_users.first_name', 'medical_users.last_name', 
                    'flight_mates.service_type', 'flight_mates.hourly_rate')
            ->orderBy('booking_date', 'desc')
            ->get();

        // Check if user is a flight mate and get received bookings
        $isFlightMate = FlightMate::where('user_id', Auth::user()->user_id)->exists();
        $receivedBookings = null;
        
        if ($isFlightMate) {
            $receivedBookings = FlightMateBooking::join('medical_users', 'flight_mate_bookings.user_id', '=', 'medical_users.user_id')
                ->join('flight_mates', 'flight_mate_bookings.flight_mate_id', '=', 'flight_mates.id')
                ->where('flight_mates.user_id', Auth::user()->user_id)
                ->select('flight_mate_bookings.*', 'medical_users.first_name', 'medical_users.last_name')
                ->orderBy('booking_date', 'desc')
                ->get();
        }
                
        return view('medical.travel.flightmates.index', 
            compact('flightMates', 'myBookings', 'isFlightMate', 'receivedBookings'));
    }

    public function register()
    {
        return view('medical.travel.flightmates.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'languages' => 'required|string',
            'experience' => 'required|string',
            'hourly_rate' => 'required|numeric',
            'service_type' => 'required|in:translator,travel_agent,medical_assistant',
            'certification' => 'nullable|string'
        ]);

        // Get the authenticated user's ID from medical_users table
        $userId = Auth::user()->user_id; // Using user_id instead of id

        $flightMate = new FlightMate($validated);
        $flightMate->user_id = $userId;
        $flightMate->save();

        return redirect()->route('medical.travel.flightmate')
            ->with('success', 'Successfully registered as a Flight Mate!');
    }

    public function showBookingForm(FlightMate $flightMate)
    {
        $flightMate = FlightMate::join('medical_users', 'flight_mates.user_id', '=', 'medical_users.user_id')
            ->select('flight_mates.*', 'medical_users.first_name', 'medical_users.last_name')
            ->where('flight_mates.id', $flightMate->id)
            ->firstOrFail();

        return view('medical.travel.flightmates.book', compact('flightMate'));
    }

    public function storeBooking(Request $request, $flightMateId)
    {
        // Validate the request
        $validated = $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'notes' => 'nullable|string|max:1000'
        ]);

        try {
            // Get the flight mate details
            $flightMate = FlightMate::findOrFail($flightMateId);

            // Calculate total amount based on duration
            $startTime = strtotime($validated['booking_date'] . ' ' . $validated['start_time']);
            $endTime = strtotime($validated['booking_date'] . ' ' . $validated['end_time']);
            $duration = ($endTime - $startTime) / 3600; // Convert to hours
            $totalAmount = $duration * $flightMate->hourly_rate;

            // Create the booking
            $booking = FlightMateBooking::create([
                'user_id' => Auth::user()->user_id,
                'flight_mate_id' => $flightMateId,
                'booking_date' => $validated['booking_date'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'status' => 'pending',
                'notes' => $validated['notes'],
                'total_amount' => $totalAmount
            ]);

            return redirect()->route('medical.travel.flightmate')
                ->with('success', 'Your flight mate booking has been confirmed! We will notify you once the flight mate accepts.');

        } catch (\Exception $e) {
            Log::error('Flight mate booking error: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'There was an error processing your booking. Please try again.')
                ->withInput();
        }
    }

    public function updateBookingStatus(Request $request, FlightMateBooking $booking)
    {
        // Verify the flight mate owns this booking
        $flightMate = FlightMate::where('user_id', Auth::user()->user_id)->first();
        
        if (!$flightMate || $booking->flight_mate_id !== $flightMate->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'status' => 'required|in:confirmed,cancelled'
        ]);

        $booking->update([
            'status' => $validated['status']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking status updated successfully'
        ]);
    }
}