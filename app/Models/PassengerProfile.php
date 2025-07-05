<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassengerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'emergency_contact_name',
        'emergency_contact_phone',
        'preferences',
        'rating',
        'total_trips',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
    ];

    /**
     * Get the user that owns the passenger profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
