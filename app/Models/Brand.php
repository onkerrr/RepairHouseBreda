<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all device models for this brand.
     */
    public function deviceModels(): HasMany
    {
        return $this->hasMany(DeviceModel::class);
    }

    /**
     * Get all active device models for this brand.
     */
    public function activeDeviceModels(): HasMany
    {
        return $this->hasMany(DeviceModel::class)->where('is_active', true);
    }

    /**
     * Scope to get only active brands.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
