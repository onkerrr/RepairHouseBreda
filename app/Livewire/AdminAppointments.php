<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Appointment;
use App\Models\RepairType;
use App\Models\User;
use App\AppointmentStatus;
use App\AppointmentSubStatus;
use Livewire\Attributes\On;

class AdminAppointments extends Component
{
    public $statusFilter = 'all';
    
    // Modal state
    public $showModal = false;
    public $editingAppointmentId = null;
    
    // Form fields
    public $user_id;
    public $repair_type_id;
    public $appointment_date;
    public $issue_description;
    public $status;
    public $sub_status;
    public $estimated_repair_duration;

    // Delete confirmation
    public $showDeleteModal = false;
    public $deletingAppointmentId = null;

    #[On('appointment-created')]
    #[On('appointment-updated')]
    public function refreshAppointments()
    {
        // Trigger re-render
    }

    public function getAppointmentsProperty()
    {
        $query = Appointment::with(['user', 'repairType'])
            ->orderBy('appointment_date', 'desc');

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        return $query->get();
    }

    public function getUsersProperty()
    {
        return User::orderBy('name')->get();
    }

    public function getRepairTypesProperty()
    {
        return RepairType::orderBy('brand')->get();
    }

    public function create()
    {
        $this->reset(['user_id', 'repair_type_id', 'appointment_date', 'issue_description', 'status', 'sub_status', 'estimated_repair_duration']);
        $this->status = AppointmentStatus::Pending->value;
        $this->editingAppointmentId = null;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        
        $this->editingAppointmentId = $id;
        $this->user_id = $appointment->user_id;
        $this->repair_type_id = $appointment->repair_type_id;
        $this->appointment_date = $appointment->appointment_date->format('Y-m-d\TH:i');
        $this->issue_description = $appointment->issue_description;
        $this->status = $appointment->status->value;
        $this->sub_status = $appointment->sub_status?->value;
        $this->estimated_repair_duration = $appointment->estimated_repair_duration;
        
        $this->showModal = true;
    }

    public function save()
    {
        $validated = $this->validate([
            'repair_type_id' => 'required|exists:repair_types,id',
            'appointment_date' => 'required|date',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'user_id' => 'nullable|exists:users,id',
            'issue_description' => 'nullable|string|max:1000',
            'sub_status' => 'nullable|in:waiting_for_parts,contact_customer,cancelled_repair',
            'estimated_repair_duration' => 'nullable|integer|min:1|max:480',
        ]);

        // Convert status strings to enums
        $validated['status'] = AppointmentStatus::from($validated['status']);
        if (!empty($validated['sub_status'])) {
            $validated['sub_status'] = AppointmentSubStatus::from($validated['sub_status']);
        }

        if ($this->editingAppointmentId) {
            $appointment = Appointment::findOrFail($this->editingAppointmentId);
            $appointment->update($validated);
            
            $this->dispatch('appointment-updated');
            session()->flash('message', 'Afspraak succesvol bijgewerkt!');
        } else {
            Appointment::create($validated);
            
            $this->dispatch('appointment-created');
            session()->flash('message', 'Afspraak succesvol aangemaakt!');
        }

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->deletingAppointmentId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        if ($this->deletingAppointmentId) {
            Appointment::findOrFail($this->deletingAppointmentId)->delete();
            
            $this->dispatch('appointment-updated');
            session()->flash('message', 'Afspraak succesvol verwijderd!');
        }

        $this->closeDeleteModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['editingAppointmentId', 'user_id', 'repair_type_id', 'appointment_date', 'issue_description', 'status', 'sub_status', 'estimated_repair_duration']);
        $this->resetValidation();
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingAppointmentId = null;
    }

    public function render()
    {
        return view('livewire.admin-appointments');
    }
}
