<?php

namespace App;

enum AppointmentStatus: string
{
    case Pending = 'pending';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::Pending => 'In afwachting',
            self::InProgress => 'Bezig',
            self::Completed => 'Voltooid',
            self::Cancelled => 'Geannuleerd',
        };
    }

    /**
     * Check if this status allows a sub-status
     */
    public function allowsSubStatus(): bool
    {
        return $this === self::InProgress;
    }
}
