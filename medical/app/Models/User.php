<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'medical_users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'date_of_birth',
        'gender',
        'phone',
        'address',
        'role'
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'created_at' => 'datetime'
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'user_id');
    }

    public function doctorAppointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function flightMate()
    {
        return $this->hasOne(FlightMate::class);
    }

    /**
     * Get the flight mate bookings made by the user
     */
    public function flightMateBookings()
    {
        return $this->hasMany(FlightMateBooking::class);
    }
    public function insurance()
    {
        return $this->hasOne(Insurance::class);
    }
}
