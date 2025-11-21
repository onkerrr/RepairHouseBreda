<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\DeviceModel;
use App\Models\Part;
use Livewire\Component;
use Livewire\Attributes\On;

class AdminParts extends Component
{
    public $parts;
    public $brands;
    public $deviceModels = [];
    public $showModal = false;
    public $showDeleteModal = false;
    public $showDetailModal = false;
    public $showStockModal = false;

    public $partId;
    public $device_model_id;
    public $selected_brand_id;
    public $name;
    public $sku;
    public $description;
    public $price;
    public $stock;
    public $min_stock;
    public $is_active = true;

    public $selectedPart;
    public $stockAdjustment;
    public $stockOperation = 'add'; // add or subtract
    public $filterStatus = 'all'; // all, active, inactive, low_stock, out_of_stock
    public $filterBrand = 'all';
    public $filterModel = 'all';

    protected $rules = [
        'device_model_id' => 'required|exists:device_models,id',
        'name' => 'required|string|max:255',
        'sku' => 'required|string|max:255|unique:parts,sku',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'min_stock' => 'required|integer|min:0',
        'is_active' => 'boolean',
    ];

    public function mount()
    {
        $this->loadParts();
        $this->loadBrands();
    }

    public function loadBrands()
    {
        $this->brands = Brand::active()->orderBy('name')->get();
    }

    public function updatedSelectedBrandId($value)
    {
        if ($value) {
            $this->deviceModels = DeviceModel::where('brand_id', $value)
                ->active()
                ->orderBy('name')
                ->get();
        } else {
            $this->deviceModels = [];
        }
        $this->device_model_id = null;
    }

    public function loadParts()
    {
        $query = Part::with(['deviceModel.brand'])->latest();

        if ($this->filterStatus === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterStatus === 'inactive') {
            $query->where('is_active', false);
        } elseif ($this->filterStatus === 'low_stock') {
            $query->lowStock()->where('is_active', true);
        } elseif ($this->filterStatus === 'out_of_stock') {
            $query->outOfStock();
        }

        if ($this->filterBrand !== 'all') {
            $query->whereHas('deviceModel', function($q) {
                $q->where('brand_id', $this->filterBrand);
            });
        }

        if ($this->filterModel !== 'all') {
            $query->where('device_model_id', $this->filterModel);
        }

        $this->parts = $query->get();
    }

    public function setFilter($status)
    {
        $this->filterStatus = $status;
        $this->loadParts();
    }

    public function setBrandFilter($brandId)
    {
        $this->filterBrand = $brandId;
        $this->filterModel = 'all';
        $this->loadParts();
    }

    public function setModelFilter($modelId)
    {
        $this->filterModel = $modelId;
        $this->loadParts();
    }

    public function create()
    {
        $this->reset(['partId', 'selected_brand_id', 'device_model_id', 'name', 'sku', 'description', 'price', 'stock', 'min_stock']);
        $this->is_active = true;
        $this->deviceModels = [];
        $this->showModal = true;
    }

    public function edit($id)
    {
        $part = Part::with('deviceModel.brand')->findOrFail($id);

        $this->partId = $part->id;
        $this->selected_brand_id = $part->deviceModel->brand_id;
        $this->device_model_id = $part->device_model_id;
        $this->name = $part->name;
        $this->sku = $part->sku;
        $this->description = $part->description;
        $this->price = $part->price;
        $this->stock = $part->stock;
        $this->min_stock = $part->min_stock;
        $this->is_active = $part->is_active;

        $this->deviceModels = DeviceModel::where('brand_id', $this->selected_brand_id)
            ->active()
            ->orderBy('name')
            ->get();

        $this->showModal = true;
    }

    public function show($id)
    {
        $this->selectedPart = Part::with('deviceModel.brand')->findOrFail($id);
        $this->showDetailModal = true;
    }

    public function openStockModal($id)
    {
        $this->selectedPart = Part::findOrFail($id);
        $this->stockAdjustment = null;
        $this->stockOperation = 'add';
        $this->showStockModal = true;
    }

    public function adjustStock()
    {
        $this->validate([
            'stockAdjustment' => 'required|integer|min:1',
        ]);

        $part = Part::findOrFail($this->selectedPart->id);

        if ($this->stockOperation === 'add') {
            $part->increaseStock($this->stockAdjustment);
            session()->flash('message', "Voorraad verhoogd met {$this->stockAdjustment} stuks.");
        } else {
            if ($part->decreaseStock($this->stockAdjustment)) {
                session()->flash('message', "Voorraad verlaagd met {$this->stockAdjustment} stuks.");
            } else {
                session()->flash('error', 'Onvoldoende voorraad voor deze actie.');
                return;
            }
        }

        $this->showStockModal = false;
        $this->loadParts();
    }

    public function save()
    {
        if ($this->partId) {
            $this->validate([
                'device_model_id' => 'required|exists:device_models,id',
                'name' => 'required|string|max:255',
                'sku' => 'required|string|max:255|unique:parts,sku,' . $this->partId,
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'min_stock' => 'required|integer|min:0',
                'is_active' => 'boolean',
            ]);

            $part = Part::findOrFail($this->partId);
            $part->update([
                'device_model_id' => $this->device_model_id,
                'name' => $this->name,
                'sku' => $this->sku,
                'description' => $this->description,
                'price' => $this->price,
                'stock' => $this->stock,
                'min_stock' => $this->min_stock,
                'is_active' => $this->is_active,
            ]);

            session()->flash('message', 'Onderdeel succesvol bijgewerkt.');
        } else {
            $this->validate();

            Part::create([
                'device_model_id' => $this->device_model_id,
                'name' => $this->name,
                'sku' => $this->sku,
                'description' => $this->description,
                'price' => $this->price,
                'stock' => $this->stock,
                'min_stock' => $this->min_stock,
                'is_active' => $this->is_active,
            ]);

            session()->flash('message', 'Onderdeel succesvol aangemaakt.');
        }

        $this->showModal = false;
        $this->loadParts();
        $this->dispatch('part-updated');
    }

    public function confirmDelete($id)
    {
        $this->partId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        Part::findOrFail($this->partId)->delete();

        $this->showDeleteModal = false;
        $this->loadParts();

        session()->flash('message', 'Onderdeel succesvol verwijderd.');
        $this->dispatch('part-deleted');
    }

    #[On('brand-updated')]
    #[On('model-updated')]
    public function refreshData()
    {
        $this->loadBrands();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->showDetailModal = false;
        $this->showStockModal = false;
    }

    public function render()
    {
        return view('livewire.admin-parts');
    }
}
