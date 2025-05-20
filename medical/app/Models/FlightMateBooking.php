<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FlightMateBooking extends Model
{
    use HasFactory;

    protected $table = 'flight_mate_bookings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'flight_mate_id',
        'booking_date',
        'start_time',
        'end_time',
        'status',
        'notes',
        'total_amount'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'booking_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'total_amount' => 'decimal:2'
    ];

    /**
     * Get the user who made the booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the flight mate being booked.
     */
    public function flightMate()
    {
        return $this->belongsTo(FlightMate::class);
    }

    /**
     * Scope a query to only include pending bookings.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include confirmed bookings.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Calculate duration in hours
     */
    public function getDurationAttribute()
    {
        $startTime = Carbon::parse($this->start_time);
        $endTime = Carbon::parse($this->end_time);
        return $startTime->diffInHours($endTime);
    }

    /**
     * Calculate total amount before saving
     */
    protected static function booted()
    {
        static::creating(function ($booking) {
            $startTime = Carbon::parse($booking->start_time);
            $endTime = Carbon::parse($booking->end_time);
            $duration = $startTime->diffInHours($endTime);
            $hourlyRate = $booking->flightMate->hourly_rate;
            $booking->total_amount = $duration * $hourlyRate;
        });
    }
}