<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';
    
    protected $fillable = [
        'name',
        'contact',
        'email',
        'country',
        'flight_number',
        'rating',
        'comments'
    ];

    protected $casts = [
        'rating' => 'integer',
        'created_at' => 'datetime'
    ];
}