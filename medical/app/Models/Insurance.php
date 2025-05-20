<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Insurance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'plan_type',
        'cost',
        'payment_method',
        'payment_status',
        'start_date',
        'end_date'
    ];

    protected $guarded = [];  // Add this to allow all mass assignments

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'cost' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'user_id' => 'integer'  // Add this to ensure proper type casting
    ];

    /**
     * Get the user that owns the insurance.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }
}