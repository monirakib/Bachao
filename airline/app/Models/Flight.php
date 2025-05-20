<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $primaryKey = 'Flight_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'Flight_ID',
        'Start_time',
        'Duration',
        'End_time',
        'Flight_from',
        'Flight_to',
        'Start_date',
        'Land_date',
        'Price',
        'Type'
    ];

    public function seats()
    {
        return $this->hasMany(Seat::class, 'flight_id', 'Flight_ID');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'flight_id', 'Flight_ID');
    }
}