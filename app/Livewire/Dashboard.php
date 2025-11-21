<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Brand;
use App\Models\DeviceModel;
use App\Models\Offer;
use App\Models\Part;
use App\AppointmentStatus;
use Livewire\Component;

class Dashboard extends Component
{
    public $pendingAppointments = 0;
    public $confirmedAppointments = 0;
    public $completedAppointments = 0;
    public $activeOffers = 0;
    public $lowStockParts = 0;
    public $outOfStockParts = 0;
    public $totalBrands = 0;
    public $totalModels = 0;
    public $totalParts = 0;
    public $recentAppointments = [];
    public $lowStockPartsList = [];

    public function mount()
    {
        $this->loadMetrics();
    }

    public function loadMetrics()
    {
        // Appointment metrics
        $this->pendingAppointments = Appointment::where('status', AppointmentStatus::Pending)->count();
        $this->confirmedAppointments = Appointment::where('status', AppointmentStatus::InProgress)->count();
        $this->completedAppointments = Appointment::where('status', AppointmentStatus::Completed)->count();

        // Offer metrics
        $this->activeOffers = Offer::whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->count();

        // Inventory metrics
        $this->totalBrands = Brand::active()->count();
        $this->totalModels = DeviceModel::active()->count();
        $this->totalParts = Part::active()->count();
        $this->lowStockParts = Part::lowStock()->where('is_active', true)->count();
        $this->outOfStockParts = Part::outOfStock()->where('is_active', true)->count();

        // Recent appointments
        $this->recentAppointments = Appointment::with(['user', 'repairType'])
            ->latest()
            ->take(5)
            ->get();

        // Low stock parts list
        $this->lowStockPartsList = Part::with('deviceModel.brand')
            ->lowStock()
            ->where('is_active', true)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
