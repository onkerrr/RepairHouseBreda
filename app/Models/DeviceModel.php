<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeviceModel extends Model
{
    protected $fillable = [
        'brand_id',
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the brand that owns this device model.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get all parts for this device model.
     */
    public function parts(): HasMany
    {
        return $this->hasMany(Part::class);
    }

    /**
     * Get all active parts for this device model.
     */
    public function activeParts(): HasMany
    {
        return $this->hasMany(Part::class)->where('is_active', true);
    }

    /**
     * Get parts that are low in stock.
     */
    public function lowStockParts(): HasMany
    {
        return $this->hasMany(Part::class)
            ->whereColumn('stock', '<=', 'min_stock')
            ->where('is_active', true);
    }

    /**
     * Scope to get only active device models.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
