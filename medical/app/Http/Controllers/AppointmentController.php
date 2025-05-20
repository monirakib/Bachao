<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmationMail;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = DB::select("
            SELECT 
                a.*,
                CONCAT(d.first_name, ' ', d.last_name) as doctor_name,
                d.specialization as department
            FROM appointments a
            LEFT JOIN medical_users d ON a.doctor_id = d.user_id
            WHERE a.user_id = ?
            ORDER BY a.date DESC, a.time DESC
        ", [Auth::id()]);

        return view('appointments.index', ['appointments' => $appointments]);
    }

    public function getAvailableSlots(Request $request)
    {
        try {
            $validated = $request->validate([
                'doctor_id' => 'required|exists:medical_users,user_id',
                'date' => 'required|date'
            ]);

            $slots = DB::select("
                SELECT 
                    id,
                    time,
                    TIME_FORMAT(time, '%h:%i %p') as formatted_time
                FROM doctor_slots 
                WHERE doctor_id = ? 
                AND date = ?
                AND is_booked = 0
                ORDER BY time ASC
            ", [
                $validated['doctor_id'],
                $validated['date']
            ]);

            return response()->json($slots);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error loading time slots: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createSlots(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:medical_users,user_id',
            'date' => 'required|date|after:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'interval' => 'required|integer|min:15'
        ]);

        try {
            $start = strtotime($validated['start_time']);
            $end = strtotime($validated['end_time']);
            $interval = $validated['interval'] * 60; // Convert minutes to seconds

            $slots = [];
            for ($time = $start; $time < $end; $time += $interval) {
                $slots[] = [
                    'doctor_id' => $validated['doctor_id'],
                    'date' => $validated['date'],
                    'time' => date('H:i:s', $time)
                ];
            }

            foreach ($slots as $slot) {
                DB::insert("
                    INSERT INTO doctor_slots (doctor_id, date, time)
                    VALUES (?, ?, ?)
                ", [$slot['doctor_id'], $slot['date'], $slot['time']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Slots created successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating slots: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bookSlot(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $slot = DB::selectOne("
                SELECT * FROM doctor_slots 
                WHERE id = ? AND is_booked = 0
                FOR UPDATE
            ", [$request->slot_id]);

            if (!$slot) {
                return response()->json([
                    'success' => false,
                    'message' => 'Slot no longer available'
                ], 400);
            }

            DB::update("
                UPDATE doctor_slots 
                SET is_booked = 1 
                WHERE id = ?
            ", [$request->slot_id]);

            DB::insert("
                INSERT INTO appointments 
                (user_id, doctor_id, date, time, status, created_at)
                VALUES (?, ?, ?, ?, 'scheduled', NOW())
            ", [Auth::id(), $slot->doctor_id, $slot->date, $slot->time]);

            DB::commit();
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error booking appointment'
            ], 500);
        }
    }

    public function create()
    {
        $doctors = DB::select("
            SELECT user_id, first_name, last_name, specialization
            FROM medical_users
            WHERE role = 'doctor'
            ORDER BY first_name, last_name
        ");

        return view('appointments.create', ['doctors' => $doctors]);
    }
    
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Get the slot details first
            $slot = DB::table('doctor_slots')
                ->where('id', $request->time_slot)
                ->first();

            if (!$slot) {
                throw new \Exception('Selected time slot is not available');
            }

            // Get user and doctor emails from medical_users table
            $patientDetails = DB::table('medical_users')
                ->where('user_id', Auth::id())
                ->select('email', 'first_name', 'last_name')
                ->first();

            $doctorDetails = DB::table('medical_users')
                ->where('user_id', $request->doctor_id)
                ->select('email', 'first_name', 'last_name')
                ->first();

            // Create appointment
            $appointmentId = DB::table('appointments')->insertGetId([
                'user_id' => Auth::id(),
                'doctor_id' => $request->doctor_id,
                'slot_id' => $request->time_slot,
                'date' => $request->date,
                'time' => $slot->time,
                'reason' => $request->reason,
                'appointment_type' => $request->appointment_type,
                'status' => 'scheduled',
                'created_at' => now()
            ]);

            // Mark slot as booked
            DB::table('doctor_slots')
                ->where('id', $request->time_slot)
                ->update(['is_booked' => 1]);

            // Send emails
            try {
                // Patient email
                Mail::send('emails.appointment-confirmation', 
                    [
                        'appointment' => (object)[
                            'patient_name' => $patientDetails->first_name,
                            'doctor_name' => $doctorDetails->first_name,
                            'doctor_last_name' => $doctorDetails->last_name,
                            'date' => $request->date,
                            'time' => $slot->time,
                            'appointment_type' => $request->appointment_type,
                            'reason' => $request->reason
                        ],
                        'type' => 'patient'
                    ],
                    function($message) use ($patientDetails) {
                        $message->to($patientDetails->email)
                               ->subject('Appointment Confirmation');
                    }
                );

                // Doctor email
                Mail::send('emails.appointment-confirmation',
                    [
                        'appointment' => (object)[
                            'patient_name' => $patientDetails->first_name,
                            'doctor_name' => $doctorDetails->first_name,
                            'doctor_last_name' => $doctorDetails->last_name,
                            'date' => $request->date,
                            'time' => $slot->time,
                            'appointment_type' => $request->appointment_type,
                            'reason' => $request->reason
                        ],
                        'type' => 'doctor'
                    ],
                    function($message) use ($doctorDetails) {
                        $message->to($doctorDetails->email)
                               ->subject('New Appointment Scheduled');
                    }
                );

                \Log::info('Emails sent successfully to:', [
                    'patient' => $patientDetails->email,
                    'doctor' => $doctorDetails->email
                ]);

            } catch (\Exception $e) {
                \Log::error('Email sending failed:', ['error' => $e->getMessage()]);
                // Continue with appointment creation even if email fails
            }

            DB::commit();

            return redirect()
                ->route('appointments.index')
                ->with('success', 'Appointment booked successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Appointment creation failed:', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}