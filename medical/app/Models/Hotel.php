<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Booking;

class Hotel extends Model
{
    use HasFactory;

    protected $table = 'hotels';

    protected $fillable = [
        'name',
        'location',
        'description',
        'price_per_night',
        'rating',
        'image_url',
        'has_medical_facilities',
        'wheelchair_accessible',
        'amenities',
        'contact_number',
        'email'
    ];

    protected $casts = [
        'amenities' => 'array',
        'has_medical_facilities' => 'boolean',
        'wheelchair_accessible' => 'boolean',
        'price_per_night' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return '৳' . number_format($this->price_per_night, 2);
    }

    // Scopes
    public function scopeMedicalFriendly($query)
    {
        return $query->where('has_medical_facilities', true);
    }

    public function scopeWheelchairAccessible($query)
    {
        return $query->where('wheelchair_accessible', true);
    }

    public function scopeInPriceRange($query, $min, $max)
    {
        return $query->whereBetween('price_per_night', [$min, $max]);
    }

    public function scopeHighlyRated($query)
    {
        return $query->where('rating', '>=', 4);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}