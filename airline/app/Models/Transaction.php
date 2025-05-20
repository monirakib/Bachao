<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'user_id',
        'flight_id',
        'passenger_name',
        'email',
        'phone',
        'passport_number',
        'seat_number',
        'seat_type',
        'payment_method',
        'payment_number',
        'amount',
        'total_amount',
        'status',
        'insurance_amount'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'insurance_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class, 'flight_id', 'Flight_ID');
    }

    public function seat()
    {
        return $this->hasOne(Seat::class);
    }
}