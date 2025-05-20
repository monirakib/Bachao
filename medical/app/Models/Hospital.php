<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hospital extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'emergency_phone',
        'latitude',
        'longitude',
        'available_beds',
        'wait_time',
        'has_air_ambulance'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'available_beds' => 'integer',
        'wait_time' => 'integer',
        'has_air_ambulance' => 'boolean'
    ];

    // Relationship with ambulance bookings
    public function ambulanceBookings()
    {
        return $this->hasMany(AmbulanceBooking::class);
    }

    // Scope to find nearby hospitals
    public function scopeNearby($query, $latitude, $longitude, $radius = 10)
    {
        return $query->selectRaw("*, 
            (6371 * acos(cos(radians(?)) 
            * cos(radians(latitude)) 
            * cos(radians(longitude) - radians(?)) 
            + sin(radians(?)) 
            * sin(radians(latitude)))) AS distance", 
            [$latitude, $longitude, $latitude])
            ->having('distance', '<=', $radius)
            ->orderBy('distance');
    }

    // Get hospitals with available beds
    public function scopeWithAvailableBeds($query)
    {
        return $query->where('available_beds', '>', 0);
    }
}