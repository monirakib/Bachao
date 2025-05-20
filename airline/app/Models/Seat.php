<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'flight_id',
        'seat_number',
        'status',
        'transaction_id'
    ];

    public function flight()
    {
        return $this->belongsTo(Flight::class, 'flight_id', 'Flight_ID');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}