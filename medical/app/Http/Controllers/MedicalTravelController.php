<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\FlightBooking;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MedicalTravelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'search']]);
    }

    public function index()
    {
        return view('medical.travel.index');
    }

    public function search(Request $request)
    {
        $flights = Flight::query()
            ->when($request->from_location, function($query, $from) {
                return $query->where('from_location', $from);
            })
            ->when($request->to_location, function($query, $to) {
                return $query->where('to_location', $to);
            })
            ->when($request->departure_date, function($query, $date) {
                return $query->whereDate('departure_datetime', $date);
            })
            ->get();

        return view('medical.travel.search-results', compact('flights'));
    }

    public function showBookingForm(Flight $flight)
    {
        // Get all booked seats for this flight from flight_bookings table
        $bookedSeats = DB::table('flight_bookings')
            ->where('flight_id', $flight->id)
            ->pluck('seat_number')
            ->toArray();

        return view('medical.travel.book', [
            'flight' => $flight,
            'bookedSeats' => $bookedSeats
        ]);
    }

    public function book(Request $request, Flight $flight)
    {
        // Debug Auth status with full user details
        $user = Auth::user();
        Log::info('Auth Check:', [
            'is_authenticated' => Auth::check(),
            'user_details' => $user ? [
                'user_id' => $user->user_id,
                'name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email
            ] : null
        ]);

        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please login to book a flight');
        }

        if (!$user) {
            Log::error('Auth Check Failed:', [
                'session_id' => session()->getId(),
                'session_data' => session()->all()
            ]);
            return redirect()->route('login')
                ->with('error', 'User authentication failed');
        }

        try {
            DB::beginTransaction();

            // Validate the request
            $validated = $request->validate([
                'medical_condition' => 'required|string',
                'special_requirements' => 'required|string',
                'selected_seat' => 'required|string'
            ]);

            // Validate if seat is already booked
            if (in_array($request->selected_seat, $flight->booked_seats ?? [])) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'This seat is already booked. Please select another seat.');
            }

            // Check if seat is already booked
            if (FlightBooking::where('flight_id', $flight->id)
                ->where('seat_number', $request->selected_seat)
                ->exists()) {
                return back()->with('error', 'This seat has already been booked.');
            }

            // Create booking with the correct user_id
            $booking = new FlightBooking();
            $booking->user_id = $user->user_id;  // Make sure we're using the correct ID
            $booking->flight_id = $flight->id;
            $booking->booking_reference = 'MED-' . Str::random(8);
            $booking->seat_number = $request->selected_seat;
            $booking->medical_condition = $request->medical_condition;
            $booking->special_requirements = $request->special_requirements;
            $booking->status = 'pending';
            $booking->total_amount = $flight->price;

            // Debug booking data before save
            Log::info('Attempting to create booking:', [
                'user_id' => $booking->user_id,
                'flight_id' => $booking->flight_id,
                'seat' => $booking->seat_number
            ]);

            $booking->save();

            // Update available seats
            $flight->decrement('available_seats');

            DB::commit();

            return redirect()
                ->route('medical.travel.index')
                ->with('success', 'Flight booked successfully! Reference: ' . $booking->booking_reference);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Booking Error:', [
                'user_id' => $user->user_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Booking failed: ' . $e->getMessage());
        }
    }
}