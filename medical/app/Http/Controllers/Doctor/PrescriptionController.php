<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    public function create($appointmentId)
    {
        $appointment = DB::table('appointments')
            ->join('medical_users', 'appointments.user_id', '=', 'medical_users.user_id')
            ->where('appointments.id', $appointmentId)
            ->select('appointments.*', 'medical_users.first_name', 'medical_users.last_name', 'medical_users.email')
            ->first();

        // Get existing medical record if any
        $existingRecord = DB::table('medical_records')
            ->where('user_id', $appointment->user_id)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('doctor.prescriptions.create', compact('appointment', 'existingRecord'));
    }

    public function store(Request $request, $appointmentId)
    {
        $request->validate([
            'diagnosis' => 'required',
            'description' => 'required',
            'treatment' => 'required',
            'next_appointment_days' => 'required|integer|min:1|max:365'
        ]);

        DB::transaction(function () use ($request, $appointmentId) {
            // Get appointment details with user email
            $appointment = DB::table('appointments')
                ->join('medical_users', 'appointments.user_id', '=', 'medical_users.user_id')
                ->where('appointments.id', $appointmentId)
                ->select('appointments.*', 'medical_users.email')
                ->first();

            // Store only the number of days
            $next_appointment = intval($request->next_appointment_days);

            // Insert new medical record
            DB::table('medical_records')->insert([
                'user_id' => $appointment->user_id,
                'doctor_id' => Auth::id(),
                'email' => $appointment->email,
                'diagnosis' => $request->diagnosis,
                'description' => $request->description,
                'treatment' => $request->treatment,
                'next_appointment' => $next_appointment, // Storing as integer
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Update appointment status
            DB::table('appointments')
                ->where('id', $appointmentId)
                ->update(['status' => 'completed']);
        });

        return redirect()
            ->route('doctor.appointments.show', $appointmentId)
            ->with('success', 'Medical record created successfully');
    }
}