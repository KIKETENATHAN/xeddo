<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_reference',
        'user_id',
        'trip_id',
        'passenger_name',
        'passenger_email',
        'passenger_phone',
        'amount',
        'seats_booked',
        'status',
        'booking_details',
        'booking_date',
    ];

    protected $casts = [
        'booking_details' => 'array',
        'booking_date' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Generate unique booking reference
    public static function generateBookingReference()
    {
        do {
            $reference = 'XED-' . strtoupper(uniqid());
        } while (self::where('booking_reference', $reference)->exists());

        return $reference;
    }
}
