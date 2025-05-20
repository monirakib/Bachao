<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Insurance;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class InsuranceController extends Controller
{
    private $planCosts = [
        'basic' => 500,
        'premium' => 1000,
        'elite' => 1500
    ];

    public function __construct()
    {
        $this->middleware('auth');  // Remove web middleware as it's included by default
    }

    public function showPlans()
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                throw new \Exception('User not authenticated');
            }

            // Simple logging
            Log::info('Insurance plans accessed by user: ' . $user->id);

            // Return the view
            return view('insurance.plans', [
                'user' => $user
            ]);

        } catch (\Exception $e) {
            Log::error('Error accessing insurance plans: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to access insurance plans');
        }
    }

    public function purchasePlan(Request $request)
    {
        DB::beginTransaction();

        try {
            // Get authenticated user ID
            $userId = Auth::id();
            if (!$userId) {
                throw new \Exception('User not authenticated');
            }

            // Get user from medical_users table with correct structure
            $dbUser = DB::table('medical_users')
                ->select('user_id', 'first_name', 'last_name', 'email')
                ->where('user_id', $userId)
                ->first();

            if (!$dbUser) {
                Log::error('User not found', ['auth_id' => $userId]);
                throw new \Exception('User not found in database');
            }

            // Validate request
            $validated = $request->validate([
                'plan_type' => 'required|in:basic,premium,elite',
                'payment_method' => 'required|in:bkash,card,cash'
            ]);

            // Create insurance record with verified user ID
            $insurance = new Insurance();
            $insurance->user_id = $dbUser->user_id; // Use user_id from medical_users
            $insurance->plan_type = $validated['plan_type'];
            $insurance->cost = $this->planCosts[$validated['plan_type']];
            $insurance->payment_method = $validated['payment_method'];
            $insurance->payment_status = 'pending';
            $insurance->start_date = now();
            $insurance->end_date = now()->addMonth();

            if (!$insurance->save()) {
                throw new \Exception('Failed to save insurance record');
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Insurance plan created successfully',
                'insurance_id' => $insurance->id,
                'user_id' => $dbUser->user_id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Insurance purchase failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id() ?? 'null',
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to process insurance request: ' . $e->getMessage()
            ], 422);
        }
    }

    public function showPayment($id)
    {
        $insurance = Insurance::findOrFail($id);
        
        if ($insurance->payment_method === 'cash' || $insurance->payment_status === 'completed') {
            return redirect()->route('dashboard');
        }

        return view('insurance.payment', compact('insurance'));
    }

    public function confirmPayment(Request $request, $id)
    {
        try {
            $insurance = Insurance::findOrFail($id);
            
            if ($insurance->payment_method === 'bkash') {
                $request->validate([
                    'transaction_id' => 'required|string|min:10',
                    'bkash_number' => 'required|regex:/^01[3-9][0-9]{8}$/'
                ]);
            } elseif ($insurance->payment_method === 'card') {
                $request->validate([
                    'card_number' => 'required|regex:/^[0-9]{16}$/',
                    'expiry' => 'required|regex:/^(0[1-9]|1[0-2])\/([0-9]{2})$/',
                    'cvv' => 'required|regex:/^[0-9]{3,4}$/'
                ]);
            }

            $insurance->update([
                'payment_status' => 'completed',
                'transaction_id' => $request->transaction_id,
                'payment_details' => json_encode($request->except(['_token', 'cvv']))
            ]);

            $insurance->user->update([
                'insurance_type' => $insurance->plan_type,
                'insurance_id' => $insurance->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Insurance payment completed successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment confirmation failed: ' . $e->getMessage()
            ], 422);
        }
    }
}