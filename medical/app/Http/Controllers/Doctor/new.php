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
        $request->validate([
            'doctor_id' => 'required|exists:medical_users,user_id',
            'date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required',
            'reason' => 'required|string',
            'appointment_type' => 'required|in:online,offline'
        ]);

        $validated = $request->validate([
            'doctor_id' => 'required|exists:medical_users,user_id',
            'time_slot' => 'required|exists:doctor_slots,id', // Changed from slot_id to time_slot to match form
            'reason' => 'required|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            // Get slot details and verify it's available
            $slot = DB::selectOne("
                SELECT * FROM doctor_slots 
                WHERE id = ? 
                AND doctor_id = ? 
                AND is_booked = 0
                FOR UPDATE
            ", [$validated['time_slot'], $validated['doctor_id']]);

            if (!$slot) {
                return back()->with('error', 'Selected time slot is no longer available.');
            }

            // Mark slot as booked
            DB::update("
                UPDATE doctor_slots 
                SET is_booked = 1 
                WHERE id = ?
            ", [$slot->id]);

            // Create appointment record
            DB::insert("
                INSERT INTO appointments 
                (user_id, doctor_id, slot_id, date, time, reason, appointment_type, status, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, 'scheduled', NOW())
            ", [
                Auth::id(),
                $validated['doctor_id'],
                $validated['time_slot'], // Use the validated time_slot
                $slot->date,
                $slot->time,
                $validated['reason'],
                $request->appointment_type
            ]);

            // Get the appointment details with user and doctor information
            $appointmentId = DB::getPdo()->lastInsertId();
            $appointmentDetails = DB::table('appointments as a')
                ->join('medical_users as p', 'a.user_id', '=', 'p.user_id')
                ->join('medical_users as d', 'a.doctor_id', '=', 'd.user_id')
                ->where('a.id', $appointmentId)
                ->select(
                    'a.*',
                    'p.email as patient_email',
                    'p.first_name as patient_name',
                    'd.email as doctor_email',
                    'd.first_name as doctor_name',
                    'd.last_name as doctor_last_name'
                )
                ->first();

            // Send confirmation emails
            try {
                // Email to patient
                Mail::send('emails.appointment-confirmation', 
                    ['appointment' => $appointmentDetails, 'type' => 'patient'], 
                    function($message) use ($appointmentDetails) {
                        $message->to($appointmentDetails->patient_email)
                               ->subject('Appointment Confirmation');
                });

                // Email to doctor
                Mail::send('emails.appointment-confirmation', 
                    ['appointment' => $appointmentDetails, 'type' => 'doctor'], 
                    function($message) use ($appointmentDetails) {
                        $message->to($appointmentDetails->doctor_email)
                               ->subject('New Appointment Scheduled');
                });

            } catch (\Exception $e) {
                Log::error('Failed to send appointment emails: ' . $e->getMessage());
                // Continue with the appointment creation even if emails fail
            }

            DB::commit();
            return redirect()->route('appointments.index')
                ->with('success', 'Appointment booked successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Appointment booking failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to book appointment. Please try again.');
        }
    }
}