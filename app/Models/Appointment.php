<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\AppointmentStatus;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'appointment_date', 'status','issue_description', 'repair_type_id', 'estimated_repair_duration'
    ];

    protected $casts = [
    'status' => AppointmentStatus::class,
];


    public function user() {
        return $this->belongsTo(User::class);
    }

    public function repairType() {
        return $this->belongsTo(RepairType::class);
    }

    public function mailNotifications() {
        return $this->hasMany(MailNotification::class);
    }
}
