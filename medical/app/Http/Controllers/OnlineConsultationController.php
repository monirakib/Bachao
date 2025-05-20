<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OnlineConsultationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $appointments = DB::table('appointments')
            ->join('medical_users as doctors', 'appointments.doctor_id', '=', 'doctors.user_id')
            ->where(function($query) use ($user) {
                $query->where('appointments.user_id', $user->user_id)
                      ->orWhere('appointments.doctor_id', $user->user_id);
            })
            ->where('appointments.appointment_type', 'online')
            ->whereDate('appointments.date', '>=', Carbon::today())
            ->select(
                'appointments.*',
                'doctors.first_name as doctor_name',
                'doctors.specialization',
                DB::raw('CASE 
                    WHEN appointments.date < CURDATE() THEN "completed"
                    WHEN appointments.date = CURDATE() AND appointments.time <= CURTIME() THEN "ongoing"
                    ELSE "scheduled"
                END as status')
            )
            ->orderBy('appointments.date')
            ->orderBy('appointments.time')
            ->get();

        if (request()->is('*/join/*')) {
            // If this is a join request, show the consultation room view
            $appointmentId = request()->segment(3);
            $appointment = $appointments->where('id', $appointmentId)->first();
            
            if (!$appointment) {
                return redirect()->route('consultations.index')
                    ->with('error', 'Consultation not found.');
            }

            // Create or get consultation session
            $consultation = DB::table('online_consultations')
                ->where('appointment_id', $appointmentId)
                ->first();

            if (!$consultation) {
                $consultationId = DB::table('online_consultations')->insertGetId([
                    'appointment_id' => $appointmentId,
                    'status' => 'waiting',
                    'meeting_link' => 'consultation-' . uniqid(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                $consultation = DB::table('online_consultations')
                    ->where('id', $consultationId)
                    ->first();
            }

            return view('consultations.index', [
                'appointment' => $appointment,
                'consultation' => $consultation,
                'isConsultationRoom' => true
            ]);
        }

        // Otherwise show the consultations list
        return view('consultations.index', [
            'appointments' => $appointments,
            'isConsultationRoom' => false
        ]);
    }

    public function join($id)
    {
        $user = Auth::user();
        
        $appointment = DB::table('appointments')
            ->join('medical_users as doctors', 'appointments.doctor_id', '=', 'doctors.user_id')
            ->where('appointments.id', $id)
            ->where(function($query) use ($user) {
                $query->where('appointments.user_id', $user->user_id)
                      ->orWhere('appointments.doctor_id', $user->user_id);
            })
            ->first();

        if (!$appointment) {
            return redirect()->route('consultations.index')
                ->with('error', 'Consultation not found.');
        }

        // Create or update consultation session
        $consultation = DB::table('online_consultations')
            ->where('appointment_id', $id)
            ->first();

        if (!$consultation) {
            DB::table('online_consultations')->insert([
                'appointment_id' => $id,
                'status' => 'waiting',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return view('consultations.room', compact('appointment'));
    }

    public function savePrescription(Request $request, $appointmentId)
    {
        $user = Auth::user();
        if ($user->role !== 'doctor') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'prescription' => 'required|string',
            'notes' => 'required|string'
        ]);

        DB::table('online_consultations')
            ->where('appointment_id', $appointmentId)
            ->update([
                'prescription' => $request->prescription,
                'consultation_notes' => $request->notes,
                'status' => 'completed',
                'ended_at' => now(),
                'updated_at' => now()
            ]);

        return response()->json(['success' => true]);
    }
}