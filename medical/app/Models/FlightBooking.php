<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FlightBooking extends Model
{
    protected $guarded = ['id'];
    
    protected $fillable = [
        'user_id',
        'flight_id',
        'booking_reference',
        'seat_number',
        'medical_condition',
        'special_requirements',
        'status',
        'total_amount'
    ];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function store(Request $request, FlightMate $flightMate)
{
    // ... your existing validation and storage logic ...

    return redirect()->back()->with('success', 'Your flight mate booking has been confirmed! We\'ll notify you once the flight mate accepts your request.');
}
}