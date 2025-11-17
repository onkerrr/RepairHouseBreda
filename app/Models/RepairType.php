<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RepairType extends Model
{
    use HasFactory;

    protected $fillable = ['brand', 'description'];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
