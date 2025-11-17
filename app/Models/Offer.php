<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by', 'title', 'price_before', 'price_after', 'start_date', 'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'price_before' => 'decimal:2',
        'price_after' => 'decimal:2',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
