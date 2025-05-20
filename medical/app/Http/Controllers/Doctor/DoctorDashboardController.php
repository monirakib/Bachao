<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DoctorDashboardController extends Controller
{
    public function index()
    {
        // Get logged in doctor's details
        $doctor = User::where('user_id', Auth::id())
            ->where('role', 'doctor')
            ->first();
            
        if (!$doctor) {
            return redirect()->route('login')->with('error', 'Unauthorized access');
        }

        // Get today's appointments count
        $todayAppointments = Appointment::where('doctor_id', $doctor->user_id)
            ->whereDate('date', Carbon::today())
            ->count();

        // Get all appointments with patient details
        $appointments = Appointment::where('doctor_id', $doctor->user_id)
            ->join('medical_users', 'appointments.user_id', '=', 'medical_users.user_id')
            ->select(
                'appointments.*',
                'medical_users.first_name',
                'medical_users.last_name',
                'medical_users.phone',
                'medical_users.email'
            )
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        // Get total unique patients
        $totalPatients = Appointment::where('doctor_id', $doctor->user_id)
            ->distinct('user_id')
            ->count('user_id');

        // Get scheduled appointments count
        $scheduledAppointments = Appointment::where('doctor_id', $doctor->user_id)
            ->where('status', 'scheduled')
            ->count();

        return view('doctor.dashboard', compact(
            'doctor',
            'appointments',
            'todayAppointments',
            'totalPatients',
            'scheduledAppointments'
        ));
    }
}