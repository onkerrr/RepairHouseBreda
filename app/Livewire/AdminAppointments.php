<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Appointment;

class AdminAppointments extends Component
{
    public $appointments;


    public function mount()
    {
        // Haal alle appointments op, met repairType en gebruiker
        $this->appointments = Appointment::with(['user', 'repairType'])
            ->orderBy('appointment_date', 'desc')
            ->get();
    }
    public function render()
    {
        return view('livewire.admin-appointments');
    }
}
