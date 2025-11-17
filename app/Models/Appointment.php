<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\AppointmentStatus;
use App\AppointmentSubStatus;
use Illuminate\Support\Str;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'appointment_date',
        'status',
        'sub_status',
        'issue_description',
        'repair_type_id',
        'estimated_repair_duration'
    ];

    protected $casts = [
        'status' => AppointmentStatus::class,
        'sub_status' => AppointmentSubStatus::class,
        'appointment_date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($appointment) {
            if (empty($appointment->uuid)) {
                $appointment->uuid = (string) Str::uuid();
            }
        });

        // Clear sub_status if status doesn't allow it
        static::saving(function ($appointment) {
            if ($appointment->status && !$appointment->status->allowsSubStatus()) {
                $appointment->sub_status = null;
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function repairType() {
        return $this->belongsTo(RepairType::class);
    }

    public function mailNotifications() {
        return $this->hasMany(MailNotification::class);
    }
}
