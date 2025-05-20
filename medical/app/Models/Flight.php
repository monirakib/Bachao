<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $fillable = [
        'flight_number',
        'airline',
        'from_location',
        'to_location',
        'departure_datetime',
        'arrival_datetime',
        'price',
        'available_seats'
    ];

    protected $casts = [
        'departure_datetime' => 'datetime',
        'arrival_datetime' => 'datetime',
        'price' => 'decimal:2'
    ];

    public function bookings()
    {
        return $this->hasMany(FlightBooking::class);
    }
}