<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_location',
        'to_location', 
        'estimated_fare',
        'estimated_duration_minutes',
        'description',
        'is_active',
    ];

    protected $casts = [
        'estimated_fare' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Scope to get only active routes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get trips that use this route
     */
    public function trips()
    {
        return $this->hasMany(Trip::class, 'route_id');
    }

    /**
     * Get trips that match this route's locations (for legacy trips without route_id)
     */
    public function getMatchingTrips()
    {
        return Trip::where('from_location', $this->from_location)
                   ->where('to_location', $this->to_location)
                   ->with(['driver.user', 'sacco'])
                   ->latest()
                   ->get();
    }

    /**
     * Get route display name
     */
    public function getDisplayNameAttribute()
    {
        return $this->from_location . ' → ' . $this->to_location;
    }
}
