<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\DeviceModel;
use Livewire\Component;
use Livewire\Attributes\On;

class AdminDeviceModels extends Component
{
    public $deviceModels;
    public $brands;
    public $showModal = false;
    public $showDeleteModal = false;
    public $showDetailModal = false;

    public $modelId;
    public $brand_id;
    public $name;
    public $description;
    public $is_active = true;

    public $selectedModel;
    public $filterStatus = 'all'; // all, active, inactive
    public $filterBrand = 'all';

    protected $rules = [
        'brand_id' => 'required|exists:brands,id',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'is_active' => 'boolean',
    ];

    public function mount()
    {
        $this->loadDeviceModels();
        $this->loadBrands();
    }

    public function loadBrands()
    {
        $this->brands = Brand::active()->orderBy('name')->get();
    }

    public function loadDeviceModels()
    {
        $query = DeviceModel::with('brand')->withCount('parts')->latest();

        if ($this->filterStatus === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterStatus === 'inactive') {
            $query->where('is_active', false);
        }

        if ($this->filterBrand !== 'all') {
            $query->where('brand_id', $this->filterBrand);
        }

        $this->deviceModels = $query->get();
    }

    public function setFilter($status)
    {
        $this->filterStatus = $status;
        $this->loadDeviceModels();
    }

    public function setBrandFilter($brandId)
    {
        $this->filterBrand = $brandId;
        $this->loadDeviceModels();
    }

    public function create()
    {
        $this->reset(['modelId', 'brand_id', 'name', 'description']);
        $this->is_active = true;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $model = DeviceModel::findOrFail($id);

        $this->modelId = $model->id;
        $this->brand_id = $model->brand_id;
        $this->name = $model->name;
        $this->description = $model->description;
        $this->is_active = $model->is_active;

        $this->showModal = true;
    }

    public function show($id)
    {
        $this->selectedModel = DeviceModel::with('brand')->withCount('parts')->with(['parts' => function($query) {
            $query->orderBy('name');
        }])->findOrFail($id);
        $this->showDetailModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->modelId) {
            $model = DeviceModel::findOrFail($this->modelId);
            $model->update([
                'brand_id' => $this->brand_id,
                'name' => $this->name,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);

            session()->flash('message', 'Model succesvol bijgewerkt.');
        } else {
            DeviceModel::create([
                'brand_id' => $this->brand_id,
                'name' => $this->name,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);

            session()->flash('message', 'Model succesvol aangemaakt.');
        }

        $this->showModal = false;
        $this->loadDeviceModels();
        $this->dispatch('model-updated');
    }

    public function confirmDelete($id)
    {
        $this->modelId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        DeviceModel::findOrFail($this->modelId)->delete();

        $this->showDeleteModal = false;
        $this->loadDeviceModels();

        session()->flash('message', 'Model succesvol verwijderd.');
        $this->dispatch('model-deleted');
    }

    #[On('brand-updated')]
    public function refreshBrands()
    {
        $this->loadBrands();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->showDetailModal = false;
    }

    public function render()
    {
        return view('livewire.admin-device-models');
    }
}
