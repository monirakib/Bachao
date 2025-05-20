<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Transaction;
use App\Models\Seat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function create($flight_id)
    {
        $flight = Flight::findOrFail($flight_id);
        $user = Auth::user();
        
        // Get all booked seats for this flight
        $booked_seats = DB::table('seats')
            ->where('flight_id', $flight_id)
            ->where('status', 'booked')
            ->pluck('seat_number')
            ->toArray();

        return view('transactions.create', compact('flight', 'user', 'booked_seats'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        try {
            // Validate the request
            $validated = $request->validate([
                'passenger_name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'required|regex:/^01[3-9][0-9]{8}$/',
                'passport_number' => 'required|string',
                'seat_number' => 'required|string',
                'payment_method' => 'required|in:bkash,nagad,rocket',
                'payment_number' => 'required|regex:/^01[3-9][0-9]{8}$/',
                'flight_id' => 'required|exists:flights,Flight_ID'
            ]);

            // Check if seat is already booked
            $seatExists = DB::table('seats')
                ->where('flight_id', $request->flight_id)
                ->where('seat_number', $request->seat_number)
                ->where('status', 'booked')
                ->exists();

            if ($seatExists) {
                DB::rollback();
                return back()->with('error', 'This seat has already been booked. Please select another seat.');
            }

            // Calculate amounts
            $flight = Flight::find($request->flight_id);
            $baseFare = $flight->Price;
            $insuranceAmount = $this->calculateInsuranceAmount($request->insurance_plan);
            $totalAmount = $this->calculateTotalAmount($baseFare, $insuranceAmount, $request->all());

            // Create the transaction
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'flight_id' => $request->flight_id,
                'passenger_name' => $request->passenger_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'passport_number' => $request->passport_number,
                'seat_number' => $request->seat_number,
                'seat_type' => $flight->Type,
                'payment_method' => $request->payment_method,
                'payment_number' => $request->payment_number,
                'amount' => $baseFare,
                'total_amount' => $totalAmount,
                'insurance_amount' => $insuranceAmount,
                'status' => 'pending'
            ]);

            // Create seat record
            DB::table('seats')->insert([
                'flight_id' => $request->flight_id,
                'seat_number' => $request->seat_number,
                'status' => 'booked',
                'transaction_id' => $transaction->id
            ]);

            // Update user reward points
            $user = User::find(Auth::id());
            $user->reward_point += 100;
            if ($user->reward_point >= 500) {
                $user->reward_point -= 500;
            }
            $user->save();

            DB::commit();

            return redirect()
                ->route('transaction.confirmation', $transaction->id)
                ->with('success', 'Flight booked successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Booking Error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->withErrors(['error' => 'Booking failed. Please try again. ' . $e->getMessage()]);
        }
    }

    private function calculateInsuranceAmount($plan)
    {
        switch ($plan) {
            case 'basic': return 500;
            case 'premium': return 1000;
            case 'elite': return 2000;
            default: return 0;
        }
    }

    private function calculateTotalAmount($baseFare, $insuranceAmount, $data)
    {
        $total = $baseFare;
        
        // Add insurance
        $total += $insuranceAmount;
        
        // Add tax
        $total += ($baseFare * 0.15);
        
        // Apply reward discount if applicable
        if (Auth::user()->reward_point >= 500) {
            $total -= ($baseFare * 0.05);
        }
        
        return $total;
    }

    public function confirmation($id)
    {
        try {
            $transaction = Transaction::with(['flight', 'user'])->findOrFail($id);
            
            // Ensure user can only view their own transactions
            if ($transaction->user_id !== Auth::id()) {
                abort(403, 'Unauthorized access');
            }
            
            return view('transactions.confirmation', compact('transaction'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                           ->withErrors(['error' => 'Transaction not found']);
        }
    }

    private function updateMembershipLevel($user)
    {
        $points = $user->reward_point;
        
        if ($points >= 2000) {
            $user->membership_level = 'Gold';
        } elseif ($points >= 1000) {
            $user->membership_level = 'Silver';
        } else {
            $user->membership_level = 'Regular';
        }
        
        $user->save();
    }

    public function index()
    {
        $transactions = Auth::user()
            ->transactions()
            ->with('flight')
            ->latest()
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }
}