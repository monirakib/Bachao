<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Observers\AppointmentObserver;
use App\Mail\AppointmentConfirmationMail;
use Illuminate\Support\Facades\Mail;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        
        static::created(function ($appointment) {
            try {
                // Get full appointment details including user and doctor
                $appointmentDetails = self::with(['user', 'doctor'])
                    ->where('id', $appointment->id)
                    ->first();

                // Send email to patient
                Mail::to($appointmentDetails->user->email)
                    ->send(new AppointmentConfirmationMail($appointmentDetails, 'patient'));

                // Send email to doctor
                Mail::to($appointmentDetails->doctor->email)
                    ->send(new AppointmentConfirmationMail($appointmentDetails, 'doctor'));

            } catch (\Exception $e) {
                \Log::error('Email sending failed: ' . $e->getMessage());
            }
        });
    }

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
    ];

    // Define the relationship with the patient (User model)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define the relationship with the doctor (User model)
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    // Relationship with Slot
    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }

    // Scopes for filtering appointments
    public function scopeUpcoming($query)
    {
        return $query->whereDate('date', '>=', Carbon::today())
                    ->where('status', '!=', 'cancelled');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('date', Carbon::today());
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Helper methods
    public function getFormattedScheduleAttribute()
    {
        return Carbon::parse($this->date . ' ' . $this->time)->format('M d, Y h:i A');
    }

    public function getStatusBadgeClassAttribute()
    {
        return [
            'scheduled' => 'upcoming',
            'completed' => 'completed',
            'cancelled' => 'cancelled'
        ][$this->status] ?? 'upcoming';
    }
}