<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sacco extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone_number',
        'location',
        'route_from',
        'route_to',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Get the drivers that belong to this SACCO.
     */
    public function drivers(): HasMany
    {
        return $this->hasMany(DriverProfile::class);
    }

    /**
     * Get the active drivers that belong to this SACCO.
     */
    public function activeDrivers(): HasMany
    {
        return $this->hasMany(DriverProfile::class)->where('status', 'approved');
    }

    /**
     * Get the full route display.
     */
    public function getFullRouteAttribute(): string
    {
        return $this->route_from . ' - ' . $this->route_to;
    }
}
