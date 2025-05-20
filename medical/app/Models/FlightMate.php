<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FlightMateBooking;

class FlightMate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'languages',
        'experience',
        'hourly_rate',
        'service_type',
        'certification',
        'is_available'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'hourly_rate' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    /**
     * Get the user that owns the flight mate profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the bookings for the flight mate.
     */
    public function bookings()
    {
        return $this->hasMany(FlightMateBooking::class);
    }

    /**
     * Get the flight mate's full name through the user relationship.
     */
    public function getFullNameAttribute()
    {
        return $this->user->name;
    }

    /**
     * Scope a query to only include available flight mates.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }
}