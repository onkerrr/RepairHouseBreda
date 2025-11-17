<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Appointment;
use App\AppointmentStatus;
use Livewire\Attributes\On;

class SidebarNavigation extends Component
{
    public int $pendingCount = 0;

    public function mount()
    {
        $this->updatePendingCount();
    }

    #[On('appointment-created')]
    #[On('appointment-updated')]
    public function updatePendingCount()
    {
        $this->pendingCount = Appointment::where('status', AppointmentStatus::Pending)->count();
    }

    public function render()
    {
        return view('livewire.sidebar-navigation');
    }
}
