<?php

namespace App\Http\Controllers;

use App\Models\AmbulanceBooking;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class EmergencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $hospitals = Hospital::where('available_beds', '>', 0)
            ->orderBy('available_beds', 'DESC')
            ->orderBy('wait_time', 'ASC')
            ->get();

        return view('emergency.index', ['hospitals' => $hospitals]);
    }

    public function bookForm()
    {
        $hospitals = Hospital::where('available_beds', '>', 0)
            ->orderBy('available_beds', 'DESC')
            ->orderBy('wait_time', 'ASC')
            ->get();

        return view('emergency.book', compact('hospitals'));
    }

    public function showBookingForm()
    {
        $hospitals = DB::table('hospitals')
            ->where('is_active', true)
            ->select(
                'id',
                'name',
                'address',
                'available_beds',
                'normal_ambulances',
                'air_ambulances'
            )
            ->get();

        return view('emergency.book', compact('hospitals'));
    }

    public function bookAmbulance(Request $request)
    {
        try {
            // Start database transaction
            return DB::transaction(function() use ($request) {
                $user = Auth::user();
                
                // Validate request
                $request->validate([
                    'hospital_id' => 'required|exists:hospitals,id',
                    'type' => 'required|in:normal,air',
                    'pickup_location' => 'required|string',
                    'emergency_type' => 'required|string',
                    'notes' => 'nullable|string'
                ]);

                // Check hospital resources availability
                $hospital = DB::table('hospitals')
                    ->where('id', $request->hospital_id)
                    ->first();

                $ambulanceType = $request->type === 'air' ? 'air_ambulances' : 'normal_ambulances';
                
                if ($hospital->{$ambulanceType} <= 0) {
                    throw new \Exception('No ' . $request->type . ' ambulances available at this hospital');
                }

                if ($hospital->available_beds <= 0) {
                    throw new \Exception('No beds available at this hospital');
                }

                // Create emergency booking
                $bookingId = DB::table('emergency_bookings')->insertGetId([
                    'user_id' => $user->user_id,
                    'hospital_id' => $request->hospital_id,
                    'ambulance_type' => $request->type,
                    'pickup_location' => $request->pickup_location,
                    'emergency_type' => $request->emergency_type,
                    'notes' => $request->notes,
                    'status' => 'dispatched',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Update hospital resources
                DB::table('hospitals')
                    ->where('id', $request->hospital_id)
                    ->update([
                        $ambulanceType => DB::raw($ambulanceType . ' - 1'),
                        'available_beds' => DB::raw('available_beds - 1')
                    ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Ambulance has been dispatched and bed has been reserved',
                    'booking_id' => $bookingId
                ]);
            });

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to book ambulance: ' . $e->getMessage()
            ], 500);
        }
    }
}