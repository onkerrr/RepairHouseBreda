<?php

namespace App;

enum AppointmentSubStatus: string
{
    case WaitingForParts = 'waiting_for_parts';
    case ContactCustomer = 'contact_customer';
    case CancelledRepair = 'cancelled_repair';

    public function label(): string
    {
        return match($this) {
            self::WaitingForParts => 'Wachten op onderdelen',
            self::ContactCustomer => 'Klant contacteren',
            self::CancelledRepair => 'Reparatie geannuleerd',
        };
    }
}
