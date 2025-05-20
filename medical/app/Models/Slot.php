<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Slot extends Model
{
    use HasFactory;

    protected $table = 'doctor_slots';

    protected $fillable = [
        'doctor_id',
        'date',
        'time',
        'is_booked'
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
        'is_booked' => 'boolean'
    ];

    // Relationship with Doctor
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    // Relationship with Appointment
    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }

    // Scope for available slots
    public function scopeAvailable($query)
    {
        return $query->where('is_booked', false)
                    ->whereDate('date', '>=', Carbon::today());
    }

    // Scope for specific date
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    // Scope for specific doctor
    public function scopeForDoctor($query, $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }

    // Get formatted datetime
    public function getScheduledAtAttribute()
    {
        return Carbon::parse($this->date . ' ' . $this->time);
    }

    // Get formatted time
    public function getFormattedTimeAttribute()
    {
        return Carbon::parse($this->time)->format('h:i A');
    }

    // Check if slot is available
    public function isAvailable()
    {
        return !$this->is_booked;
    }
}