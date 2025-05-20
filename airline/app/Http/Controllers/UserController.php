<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:1,2',
            'current_password' => 'required_with:new_password',
            'new_password' => 'nullable|required_with:current_password|min:8|confirmed',
        ]);

        // Handle password change if requested
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()
                    ->withInput()
                    ->withErrors(['current_password' => 'The current password is incorrect.']);
            }
            
            $validated['password'] = Hash::make($request->new_password);
        }

        // Remove password fields from validated data if not changing password
        unset($validated['current_password']);
        unset($validated['new_password']);

        $user->update($validated);

        return redirect()
            ->route('user.profile')
            ->with('success', 'Profile updated successfully' . 
                ($request->filled('current_password') ? ' and password changed' : ''));
    }

    public function rewardPoints()
    {
        $user = Auth::user();
        $benefits = [
            'Bronze' => [
                'Basic reward points on bookings',
                'Access to special promotions',
                'Email notifications for deals'
            ],
            'Silver' => [
                'Extra 50% reward points on bookings',
                'Priority check-in',
                'Free seat selection',
                'Exclusive member discounts'
            ],
            'Gold' => [
                'Double reward points on bookings',
                'Priority boarding',
                'Lounge access',
                'Free baggage upgrade',
                'Dedicated customer service'
            ]
        ];

        return view('user.reward-points', [
            'user' => $user,
            'benefits' => $benefits,
            'total_points' => $user->reward_point,
            'membership_level' => $user->membership_level
        ]);
    }

    public function updateMembershipLevel()
    {
        $authUser = Auth::user();
        $user = User::find($authUser->user_id);
        $points = $user->reward_point;

        $membership_level = match(true) {
            $points >= 1000 => 'Gold',
            $points >= 500 => 'Silver',
            default => 'Bronze'
        };

        $user->membership_level = $membership_level;
        $user->save();
        return $membership_level;
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }
}