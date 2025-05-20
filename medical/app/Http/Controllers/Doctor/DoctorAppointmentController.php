<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DoctorAppointmentController extends Controller
{
    public function index()
    {
        $doctor_id = Auth::id();
        
        $appointments = Appointment::where('doctor_id', $doctor_id)
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
            ->paginate(10);

        return view('doctor.appointments.index', compact('appointments'));
    }

    public function show(Appointment $appointment)
    {
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403);
        }

        return view('doctor.appointments.show', compact('appointment'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:scheduled,completed,cancelled'
        ]);

        $appointment->update($validated);

        return back()->with('success', 'Appointment status updated successfully');
    }
}