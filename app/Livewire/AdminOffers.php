<?php

namespace App\Livewire;

use App\Models\Offer;
use Livewire\Component;
use Livewire\Attributes\On;

class AdminOffers extends Component
{
    public $offers;
    public $showModal = false;
    public $showDeleteModal = false;
    public $showDetailModal = false;
    
    public $offerId;
    public $title;
    public $price_before;
    public $price_after;
    public $start_date;
    public $end_date;
    
    public $selectedOffer;
    public $filterStatus = 'all'; // all, active, expired, upcoming

    protected $rules = [
        'title' => 'required|string|max:255',
        'price_before' => 'required|numeric|min:0',
        'price_after' => 'required|numeric|min:0',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
    ];

    public function mount()
    {
        $this->loadOffers();
    }

    public function loadOffers()
    {
        $query = Offer::with('creator')->latest();

        if ($this->filterStatus === 'active') {
            $query->whereDate('start_date', '<=', now())
                  ->whereDate('end_date', '>=', now());
        } elseif ($this->filterStatus === 'expired') {
            $query->whereDate('end_date', '<', now());
        } elseif ($this->filterStatus === 'upcoming') {
            $query->whereDate('start_date', '>', now());
        }

        $this->offers = $query->get();
    }

    public function setFilter($status)
    {
        $this->filterStatus = $status;
        $this->loadOffers();
    }

    public function create()
    {
        $this->reset(['offerId', 'title', 'price_before', 'price_after', 'start_date', 'end_date']);
        $this->showModal = true;
    }

    public function edit($id)
    {
        $offer = Offer::findOrFail($id);
        
        $this->offerId = $offer->id;
        $this->title = $offer->title;
        $this->price_before = $offer->price_before;
        $this->price_after = $offer->price_after;
        $this->start_date = $offer->start_date->format('Y-m-d');
        $this->end_date = $offer->end_date->format('Y-m-d');
        
        $this->showModal = true;
    }

    public function show($id)
    {
        $this->selectedOffer = Offer::with('creator')->findOrFail($id);
        $this->showDetailModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->offerId) {
            $offer = Offer::findOrFail($this->offerId);
            $offer->update([
                'title' => $this->title,
                'price_before' => $this->price_before,
                'price_after' => $this->price_after,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
            ]);
            
            session()->flash('message', 'Aanbieding succesvol bijgewerkt.');
        } else {
            Offer::create([
                'title' => $this->title,
                'price_before' => $this->price_before,
                'price_after' => $this->price_after,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'created_by' => auth()->id(),
            ]);
            
            session()->flash('message', 'Aanbieding succesvol aangemaakt.');
        }

        $this->showModal = false;
        $this->loadOffers();
        $this->dispatch('offer-created');
    }

    public function confirmDelete($id)
    {
        $this->offerId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        Offer::findOrFail($this->offerId)->delete();
        
        $this->showDeleteModal = false;
        $this->loadOffers();
        
        session()->flash('message', 'Aanbieding succesvol verwijderd.');
        $this->dispatch('offer-deleted');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->showDetailModal = false;
    }

    public function render()
    {
        return view('livewire.admin-offers');
    }
}
