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
        'sacco_id',
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

    /**
     * Get the SACCO that this driver belongs to.
     */
    public function sacco()
    {
        return $this->belongsTo(Sacco::class);
    }

    /**
     * Get the trips for this driver.
     */
    public function trips()
    {
        return $this->hasMany(Trip::class, 'driver_id');
    }
}
