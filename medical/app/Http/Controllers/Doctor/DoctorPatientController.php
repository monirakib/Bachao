<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DoctorPatientController extends Controller
{
    public function index()
    {
        $doctor_id = Auth::id();
        
        // Get unique patients who have appointments with this doctor
        $patients = User::whereIn('user_id', function($query) use ($doctor_id) {
            $query->select('user_id')
                  ->from('appointments')
                  ->where('doctor_id', $doctor_id)
                  ->distinct();
        })
        ->select('user_id', 'first_name', 'last_name', 'email', 'phone', 'gender')
        ->paginate(10);

        return view('doctor.patients.index', compact('patients'));
    }

    public function show(User $user)
    {
        $doctor_id = Auth::id();
        
        // Check if this patient has appointments with the current doctor
        $hasAppointments = Appointment::where('doctor_id', $doctor_id)
            ->where('user_id', $user->user_id)
            ->exists();

        if (!$hasAppointments) {
            abort(403);
        }

        // Get patient's appointments with this doctor
        $appointments = Appointment::where('doctor_id', $doctor_id)
            ->where('user_id', $user->user_id)
            ->orderBy('date', 'desc')
            ->get();

        return view('doctor.patients.show', compact('user', 'appointments'));
    }
}