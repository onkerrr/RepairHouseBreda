<div>
    @if (session()->has('message'))
        <div class="mb-4 rounded-lg bg-green-50 dark:bg-green-900/20 p-4 text-sm text-green-800 dark:text-green-400 border border-green-200 dark:border-green-800">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">Aanbiedingen Beheer</h2>
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Beheer alle aanbiedingen en kortingsacties</p>
        </div>
        <button wire:click="create" class="inline-flex items-center px-4 py-2 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-semibold rounded-md hover:bg-zinc-700 dark:hover:bg-zinc-100 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nieuwe Aanbieding
        </button>
    </div>

    <div class="mb-6 flex flex-wrap gap-2">
        <button wire:click="setFilter('all')" class="px-4 py-2 rounded-md font-medium transition-colors {{ $filterStatus === 'all' ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
            Alle
        </button>
        <button wire:click="setFilter('active')" class="px-4 py-2 rounded-md font-medium transition-colors {{ $filterStatus === 'active' ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
            Actief
        </button>
        <button wire:click="setFilter('upcoming')" class="px-4 py-2 rounded-md font-medium transition-colors {{ $filterStatus === 'upcoming' ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
            Binnenkort
        </button>
        <button wire:click="setFilter('expired')" class="px-4 py-2 rounded-md font-medium transition-colors {{ $filterStatus === 'expired' ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
            Verlopen
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($offers as $offer)
            @php
                $isActive = $offer->start_date->isPast() && $offer->end_date->isFuture();
                $isExpired = $offer->end_date->isPast();
                $isUpcoming = $offer->start_date->isFuture();
                $discount = round((($offer->price_before - $offer->price_after) / $offer->price_before) * 100);
            @endphp
            
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden hover:shadow-md transition-shadow">
                <div class="bg-zinc-900 dark:bg-zinc-950 p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium px-3 py-1 rounded
                            {{ $isActive ? 'bg-green-500/20 text-green-300' : '' }}
                            {{ $isExpired ? 'bg-red-500/20 text-red-300' : '' }}
                            {{ $isUpcoming ? 'bg-blue-500/20 text-blue-300' : '' }}">
                            @if($isActive)
                                Actief
                            @elseif($isExpired)
                                Verlopen
                            @else
                                Binnenkort
                            @endif
                        </span>
                        <span class="text-white text-2xl font-bold">
                            -{{ $discount }}%
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-3 line-clamp-2">
                        {{ $offer->title }}
                    </h3>

                    <div class="flex items-end gap-3 mb-4">
                        <div class="text-2xl font-bold text-zinc-900 dark:text-white">
                            €{{ number_format($offer->price_after, 2, ',', '.') }}
                        </div>
                        <div class="text-lg text-zinc-500 dark:text-zinc-400 line-through mb-0.5">
                            €{{ number_format($offer->price_before, 2, ',', '.') }}
                        </div>
                    </div>

                    <div class="space-y-2 mb-4 text-sm text-zinc-600 dark:text-zinc-400">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $offer->start_date->format('d-m-Y') }} t/m {{ $offer->end_date->format('d-m-Y') }}
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ $offer->creator->name ?? 'Onbekend' }}
                        </div>
                    </div>

                    <div class="flex gap-2 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                        <button wire:click="show({{ $offer->id }})" class="flex-1 px-3 py-2 bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-600 transition-colors text-sm font-medium">
                            Bekijken
                        </button>
                        <button wire:click="edit({{ $offer->id }})" class="flex-1 px-3 py-2 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-md hover:bg-zinc-700 dark:hover:bg-zinc-100 transition-colors text-sm font-medium">
                            Bewerken
                        </button>
                        <button wire:click="confirmDelete({{ $offer->id }})" class="px-3 py-2 bg-red-600 dark:bg-red-500 text-white rounded-md hover:bg-red-700 dark:hover:bg-red-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700">
                <svg class="w-16 h-16 mx-auto text-zinc-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-2">Geen aanbiedingen gevonden</h3>
                <p class="text-zinc-600 dark:text-zinc-400 mb-4">
                    @if($filterStatus === 'all')
                        Er zijn nog geen aanbiedingen aangemaakt.
                    @else
                        Geen aanbiedingen met status "{{ ucfirst($filterStatus) }}".
                    @endif
                </p>
                @if($filterStatus !== 'all')
                    <button wire:click="setFilter('all')" class="text-zinc-900 dark:text-white font-semibold hover:underline">
                        Bekijk alle aanbiedingen
                    </button>
                @endif
            </div>
        @endforelse
    </div>

    @if($showModal)
        <div class="fixed inset-0 bg-zinc-900/50 dark:bg-black/70 flex items-center justify-center p-4 z-50">
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white">
                        {{ $offerId ? 'Aanbieding Bewerken' : 'Nieuwe Aanbieding' }}
                    </h3>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Titel *
                        </label>
                        <input type="text" wire:model="title" 
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-2 focus:ring-zinc-500 dark:focus:ring-zinc-400 focus:border-transparent">
                        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Prijs Voor *
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-zinc-500">€</span>
                                <input type="number" step="0.01" wire:model="price_before" 
                                    class="w-full pl-8 pr-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-2 focus:ring-zinc-500 dark:focus:ring-zinc-400 focus:border-transparent">
                            </div>
                            @error('price_before') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Prijs Na *
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-zinc-500">€</span>
                                <input type="number" step="0.01" wire:model="price_after" 
                                    class="w-full pl-8 pr-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-2 focus:ring-zinc-500 dark:focus:ring-zinc-400 focus:border-transparent">
                            </div>
                            @error('price_after') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Startdatum *
                            </label>
                            <input type="date" wire:model="start_date" 
                                class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-2 focus:ring-zinc-500 dark:focus:ring-zinc-400 focus:border-transparent">
                            @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Einddatum *
                            </label>
                            <input type="date" wire:model="end_date" 
                                class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-2 focus:ring-zinc-500 dark:focus:ring-zinc-400 focus:border-transparent">
                            @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-3">
                    <button wire:click="closeModal" type="button" 
                        class="px-4 py-2 bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-600 transition-colors font-medium">
                        Annuleren
                    </button>
                    <button wire:click="save" type="button" 
                        class="px-4 py-2 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-md hover:bg-zinc-700 dark:hover:bg-zinc-100 transition-colors font-medium">
                        {{ $offerId ? 'Bijwerken' : 'Aanmaken' }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if($showDeleteModal)
        <div class="fixed inset-0 bg-zinc-900/50 dark:bg-black/70 flex items-center justify-center p-4 z-50">
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-zinc-900 dark:text-white">
                                Aanbieding Verwijderen
                            </h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                                Weet je zeker dat je deze aanbieding wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-3">
                    <button wire:click="closeModal" type="button" 
                        class="px-4 py-2 bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-600 transition-colors font-medium">
                        Annuleren
                    </button>
                    <button wire:click="delete" type="button" 
                        class="px-4 py-2 bg-red-600 dark:bg-red-500 text-white rounded-md hover:bg-red-700 dark:hover:bg-red-600 transition-colors font-medium">
                        Verwijderen
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if($showDetailModal && $selectedOffer)
        <div class="fixed inset-0 bg-zinc-900/50 dark:bg-black/70 flex items-center justify-center p-4 z-50">
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-zinc-900 dark:text-white">
                                Aanbieding Details
                            </h3>
                            @php
                                $isActive = $selectedOffer->start_date->isPast() && $selectedOffer->end_date->isFuture();
                                $isExpired = $selectedOffer->end_date->isPast();
                            @endphp
                            <span class="inline-block mt-2 text-sm font-medium px-3 py-1 rounded
                                {{ $isActive ? 'bg-green-500/20 text-green-700 dark:text-green-300' : '' }}
                                {{ $isExpired ? 'bg-red-500/20 text-red-700 dark:text-red-300' : '' }}
                                {{ !$isActive && !$isExpired ? 'bg-blue-500/20 text-blue-700 dark:text-blue-300' : '' }}">
                                @if($isActive)
                                    Actief
                                @elseif($isExpired)
                                    Verlopen
                                @else
                                    Binnenkort
                                @endif
                            </span>
                        </div>
                        <button wire:click="closeModal" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <div>
                        <h4 class="text-2xl font-bold text-zinc-900 dark:text-white mb-2">
                            {{ $selectedOffer->title }}
                        </h4>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-1">Prijs Voor</p>
                            <p class="text-2xl font-bold text-zinc-500 dark:text-zinc-400 line-through">
                                €{{ number_format($selectedOffer->price_before, 2, ',', '.') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-1">Prijs Na</p>
                            <p class="text-3xl font-bold text-zinc-900 dark:text-white">
                                €{{ number_format($selectedOffer->price_after, 2, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    @php
                        $discount = round((($selectedOffer->price_before - $selectedOffer->price_after) / $selectedOffer->price_before) * 100);
                        $savings = $selectedOffer->price_before - $selectedOffer->price_after;
                    @endphp

                    <div class="bg-zinc-50 dark:bg-zinc-900 rounded-lg p-4 border border-zinc-200 dark:border-zinc-700">
                        <div class="grid grid-cols-2 gap-4 text-center">
                            <div>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-1">Korting</p>
                                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $discount }}%</p>
                            </div>
                            <div>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-1">Besparing</p>
                                <p class="text-2xl font-bold text-zinc-900 dark:text-white">€{{ number_format($savings, 2, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-3 border-b border-zinc-200 dark:border-zinc-700">
                            <svg class="w-5 h-5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Looptijd</p>
                                <p class="font-semibold text-zinc-900 dark:text-white">
                                    {{ $selectedOffer->start_date->format('d M Y') }} - {{ $selectedOffer->end_date->format('d M Y') }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 pb-3 border-b border-zinc-200 dark:border-zinc-700">
                            <svg class="w-5 h-5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Duur</p>
                                <p class="font-semibold text-zinc-900 dark:text-white">
                                    {{ $selectedOffer->start_date->diffInDays($selectedOffer->end_date) }} dagen
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 pb-3 border-b border-zinc-200 dark:border-zinc-700">
                            <svg class="w-5 h-5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <div>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Aangemaakt door</p>
                                <p class="font-semibold text-zinc-900 dark:text-white">
                                    {{ $selectedOffer->creator->name ?? 'Onbekend' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Aangemaakt op</p>
                                <p class="font-semibold text-zinc-900 dark:text-white">
                                    {{ $selectedOffer->created_at->format('d M Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-3">
                    <button wire:click="closeModal" type="button" 
                        class="px-4 py-2 bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-600 transition-colors font-medium">
                        Sluiten
                    </button>
                    <button wire:click="edit({{ $selectedOffer->id }})" type="button" 
                        class="px-4 py-2 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-md hover:bg-zinc-700 dark:hover:bg-zinc-100 transition-colors font-medium">
                        Bewerken
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
