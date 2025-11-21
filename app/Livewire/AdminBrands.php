<?php

namespace App\Livewire;

use App\Models\Brand;
use Livewire\Component;
use Livewire\Attributes\On;

class AdminBrands extends Component
{
    public $brands;
    public $showModal = false;
    public $showDeleteModal = false;
    public $showDetailModal = false;

    public $brandId;
    public $name;
    public $description;
    public $is_active = true;

    public $selectedBrand;
    public $filterStatus = 'all'; // all, active, inactive

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'is_active' => 'boolean',
    ];

    public function mount()
    {
        $this->loadBrands();
    }

    public function loadBrands()
    {
        $query = Brand::withCount('deviceModels')->latest();

        if ($this->filterStatus === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterStatus === 'inactive') {
            $query->where('is_active', false);
        }

        $this->brands = $query->get();
    }

    public function setFilter($status)
    {
        $this->filterStatus = $status;
        $this->loadBrands();
    }

    public function create()
    {
        $this->reset(['brandId', 'name', 'description']);
        $this->is_active = true;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);

        $this->brandId = $brand->id;
        $this->name = $brand->name;
        $this->description = $brand->description;
        $this->is_active = $brand->is_active;

        $this->showModal = true;
    }

    public function show($id)
    {
        $this->selectedBrand = Brand::withCount('deviceModels')->with(['deviceModels' => function($query) {
            $query->withCount('parts');
        }])->findOrFail($id);
        $this->showDetailModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->brandId) {
            $brand = Brand::findOrFail($this->brandId);
            $brand->update([
                'name' => $this->name,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);

            session()->flash('message', 'Merk succesvol bijgewerkt.');
        } else {
            Brand::create([
                'name' => $this->name,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);

            session()->flash('message', 'Merk succesvol aangemaakt.');
        }

        $this->showModal = false;
        $this->loadBrands();
        $this->dispatch('brand-updated');
    }

    public function confirmDelete($id)
    {
        $this->brandId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        Brand::findOrFail($this->brandId)->delete();

        $this->showDeleteModal = false;
        $this->loadBrands();

        session()->flash('message', 'Merk succesvol verwijderd.');
        $this->dispatch('brand-deleted');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->showDetailModal = false;
    }

    public function render()
    {
        return view('livewire.admin-brands');
    }
}
