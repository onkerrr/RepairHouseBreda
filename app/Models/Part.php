<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Part extends Model
{
    protected $fillable = [
        'device_model_id',
        'name',
        'sku',
        'description',
        'price',
        'stock',
        'min_stock',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'min_stock' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the device model that owns this part.
     */
    public function deviceModel(): BelongsTo
    {
        return $this->belongsTo(DeviceModel::class);
    }

    /**
     * Check if the part is low in stock.
     */
    public function isLowStock(): bool
    {
        return $this->stock <= $this->min_stock;
    }

    /**
     * Check if the part is out of stock.
     */
    public function isOutOfStock(): bool
    {
        return $this->stock <= 0;
    }

    /**
     * Increase stock by a given amount.
     */
    public function increaseStock(int $amount): bool
    {
        $this->stock += $amount;
        return $this->save();
    }

    /**
     * Decrease stock by a given amount.
     */
    public function decreaseStock(int $amount): bool
    {
        if ($this->stock < $amount) {
            return false;
        }

        $this->stock -= $amount;
        return $this->save();
    }

    /**
     * Scope to get only active parts.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get parts that are low in stock.
     */
    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock', '<=', 'min_stock');
    }

    /**
     * Scope to get parts that are out of stock.
     */
    public function scopeOutOfStock($query)
    {
        return $query->where('stock', '<=', 0);
    }
}
