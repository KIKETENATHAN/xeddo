<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'sacco_id',
        'from_location',
        'to_location',
        'departure_time',
        'estimated_arrival_time',
        'amount',
        'status',
        'available_seats',
        'booked_seats',
        'notes',
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'estimated_arrival_time' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function driver()
    {
        return $this->belongsTo(DriverProfile::class, 'driver_id');
    }

    public function sacco()
    {
        return $this->belongsTo(Sacco::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getRemainingSeatsAttribute()
    {
        return $this->available_seats - $this->booked_seats;
    }

    public function getFormattedAmountAttribute()
    {
        return 'KSH ' . number_format((float) $this->amount, 2);
    }
}
