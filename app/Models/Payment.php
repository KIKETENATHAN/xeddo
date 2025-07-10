<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_reference',
        'booking_id',
        'phone_number',
        'amount',
        'payment_method',
        'status',
        'transaction_id',
        'checkout_request_id',
        'merchant_request_id',
        'payment_details',
        'paid_at',
    ];

    protected $casts = [
        'payment_details' => 'array',
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->hasOneThrough(User::class, Booking::class, 'id', 'id', 'booking_id', 'user_id');
    }

    // Generate unique payment reference
    public static function generatePaymentReference()
    {
        do {
            $reference = 'PAY-' . strtoupper(uniqid());
        } while (self::where('payment_reference', $reference)->exists());

        return $reference;
    }
}
