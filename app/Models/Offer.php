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

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
