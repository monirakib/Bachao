<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Hospital;
use App\Models\User;

class AmbulanceBooking extends Model
{
    protected $fillable = [
        'user_id',
        'hospital_id',
        'type',
        'pickup_location',
        'emergency_type',
        'notes',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}