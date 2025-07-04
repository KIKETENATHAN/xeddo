<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'license_number',
        'license_expiry',
        'vehicle_type',
        'vehicle_make',
        'vehicle_model',
        'vehicle_year',
        'vehicle_plate_number',
        'vehicle_color',
        'vehicle_description',
        'status',
        'is_available',
        'rating',
        'total_trips',
    ];

    protected $casts = [
        'license_expiry' => 'date',
        'is_available' => 'boolean',
        'rating' => 'decimal:2',
    ];

    /**
     * Get the user that owns the driver profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
