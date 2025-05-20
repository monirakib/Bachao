<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DoctorSettingController extends Controller
{
    public function index()
    {
        $doctor = User::where('user_id', Auth::id())
            ->where('role', 'doctor')
            ->first();
            
        if (!$doctor) {
            return redirect()->route('login')->with('error', 'Unauthorized access');
        }

        return view('doctor.settings.index', compact('doctor'));
    }

    public function update(Request $request)
    {
        $doctor = User::where('user_id', Auth::id())
            ->where('role', 'doctor')
            ->first();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'specialization' => 'required|string|max:255',
            'address' => 'required|string|max:500'
        ]);

        $doctor->update($validated);

        return back()->with('success', 'Profile updated successfully');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect']);
        }

        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        return back()->with('success', 'Password updated successfully');
    }
}