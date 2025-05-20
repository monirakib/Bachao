<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DoctorTelemedicineController extends Controller
{
    public function index()
    {
        $doctor_id = Auth::id();
        
        $onlineAppointments = Appointment::where('doctor_id', $doctor_id)
            ->where('appointment_type', 'online')
            ->whereDate('date', '>=', Carbon::today())
            ->join('medical_users', 'appointments.user_id', '=', 'medical_users.user_id')
            ->select(
                'appointments.*',
                'medical_users.first_name',
                'medical_users.last_name',
                'medical_users.email'
            )
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->paginate(10);

        return view('doctor.telemedicine.index', compact('onlineAppointments'));
    }

    public function show(Appointment $appointment)
    {
        if ($appointment->doctor_id !== Auth::id() || $appointment->appointment_type !== 'online') {
            abort(403);
        }

        return view('doctor.telemedicine.show', compact('appointment'));
    }

    public function endSession(Request $request, Appointment $appointment)
    {
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403);
        }

        $appointment->update([
            'status' => 'completed'
        ]);

        return redirect()->route('doctor.telemedicine')
            ->with('success', 'Telemedicine session ended successfully');
    }
}