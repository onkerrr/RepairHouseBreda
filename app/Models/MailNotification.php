<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MailNotification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'mail_type', 'appointment_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function appointment() {
        return $this->belongsTo(Appointment::class);
    }
}
