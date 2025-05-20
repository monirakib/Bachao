<?php

namespace App\Observers;

use App\Models\Appointment;
use App\Mail\AppointmentConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppointmentObserver
{
    public function created(Appointment $appointment)
    {
        try {
            // Get appointment details with user and doctor information
            $appointmentDetails = DB::table('appointments as a')
                ->join('medical_users as p', 'a.user_id', '=', 'p.user_id')
                ->join('medical_users as d', 'a.doctor_id', '=', 'd.user_id')
                ->where('a.id', $appointment->id)
                ->first();

            if (!$appointmentDetails) {
                throw new \Exception('Appointment details not found');
            }

            // Debug log
            Log::info('Sending emails for appointment:', ['appointment_id' => $appointment->id]);

            try {
                // Send email to patient
                Mail::raw("Your appointment has been confirmed.", function($message) use ($appointmentDetails) {
                    $message->to($appointmentDetails->patient_email)
                           ->subject('Appointment Confirmation');
                });

                // Send email to doctor
                Mail::raw("New appointment scheduled.", function($message) use ($appointmentDetails) {
                    $message->to($appointmentDetails->doctor_email)
                           ->subject('New Appointment Alert');
                });

                Log::info('Emails sent successfully');
            } catch (\Exception $e) {
                Log::error('Mail sending failed: ' . $e->getMessage());
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('Appointment observer error: ' . $e->getMessage());
        }
    }
}