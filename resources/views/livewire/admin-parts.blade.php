<div>
    @if (session()->has('message'))
        <div class="mb-4 rounded-lg bg-green-50 dark:bg-green-900/20 p-4 text-sm text-green-800 dark:text-green-400 border border-green-200 dark:border-green-800">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 rounded-lg bg-red-50 dark:bg-red-900/20 p-4 text-sm text-red-800 dark:text-red-400 border border-red-200 dark:border-red-800">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">Onderdelen Beheer</h2>
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Beheer alle onderdelen en voorraad</p>
        </div>
        <button wire:click="create" class="inline-flex items-center px-4 py-2 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-semibold rounded-md hover:bg-zinc-700 dark:hover:bg-zinc-100 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nieuw Onderdeel
        </button>
    </div>

    <div class="mb-6 flex flex-wrap gap-2">
        <button wire:click="setFilter('all')" class="px-4 py-2 rounded-md font-medium transition-colors {{ $filterStatus === 'all' ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
            Alle
        </button>
        <button wire:click="setFilter('active')" class="px-4 py-2 rounded-md font-medium transition-colors {{ $filterStatus === 'active' ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
            Actief
        </button>
        <button wire:click="setFilter('inactive')" class="px-4 py-2 rounded-md font-medium transition-colors {{ $filterStatus === 'inactive' ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
            Inactief
        </button>
        <button wire:click="setFilter('low_stock')" class="px-4 py-2 rounded-md font-medium transition-colors {{ $filterStatus === 'low_stock' ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
            Lage Voorraad
        </button>
        <button wire:click="setFilter('out_of_stock')" class="px-4 py-2 rounded-md font-medium transition-colors {{ $filterStatus === 'out_of_stock' ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
            Uitverkocht
        </button>
        
        <div class="ml-auto flex gap-2">
            <select wire:model.live="filterBrand" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-zinc-500 dark:focus:ring-zinc-400">
                <option value="all">Alle Merken</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($parts as $part)
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden hover:shadow-md transition-shadow">
                <div class="bg-zinc-900 dark:bg-zinc-950 p-4">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-zinc-400">{{ $part->deviceModel->brand->name }}</span>
                        <span class="text-sm font-medium px-3 py-1 rounded {{ $part->is_active ? 'bg-green-500/20 text-green-300' : 'bg-red-500/20 text-red-300' }}">
                            {{ $part->is_active ? 'Actief' : 'Inactief' }}
                        </span>
                    </div>
                    <p class="text-xs text-zinc-500">{{ $part->deviceModel->name }}</p>
                </div>

                <div class="p-6">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-2">
                        {{ $part->name }}
                    </h3>
                    
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-3">
                        SKU: <span class="font-mono">{{ $part->sku }}</span>
                    </p>

                    <div class="flex items-baseline gap-2 mb-4">
                        <div class="text-2xl font-bold text-zinc-900 dark:text-white">
                            €{{ number_format($part->price, 2, ',', '.') }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Voorraad</span>
                            <span class="text-sm font-medium {{ $part->isLowStock() ? 'text-amber-600 dark:text-amber-400' : ($part->isOutOfStock() ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400') }}">
                                {{ $part->stock }} / {{ $part->min_stock }} min
                            </span>
                        </div>
                        <div class="w-full bg-zinc-200 dark:bg-zinc-700 rounded-full h-2">
                            @php
                                $percentage = $part->min_stock > 0 ? min(($part->stock / $part->min_stock) * 100, 100) : 100;
                                $color = $part->isOutOfStock() ? 'bg-red-500' : ($part->isLowStock() ? 'bg-amber-500' : 'bg-green-500');
                            @endphp
                            <div class="{{ $color }} h-2 rounded-full transition-all" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>

                    <div class="flex gap-2 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                        <button wire:click="openStockModal({{ $part->id }})" class="flex-1 px-3 py-2 bg-blue-600 dark:bg-blue-500 text-white rounded-md hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors text-sm font-medium">
                            Voorraad
                        </button>
                        <button wire:click="show({{ $part->id }})" class="px-3 py-2 bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                        <button wire:click="edit({{ $part->id }})" class="px-3 py-2 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-md hover:bg-zinc-700 dark:hover:bg-zinc-100 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button wire:click="confirmDelete({{ $part->id }})" class="px-3 py-2 bg-red-600 dark:bg-red-500 text-white rounded-md hover:bg-red-700 dark:hover:bg-red-600 transition-colors">
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-2">Geen onderdelen gevonden</h3>
                <p class="text-zinc-600 dark:text-zinc-400 mb-4">Er zijn nog geen onderdelen aangemaakt.</p>
            </div>
        @endforelse
    </div>

    {{-- Create/Edit Modal - continues below --}}
    @if($showModal)
        <div class="fixed inset-0 bg-zinc-900/50 dark:bg-black/70 flex items-center justify-center p-4 z-50">
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white">
                        {{ $partId ? 'Onderdeel Bewerken' : 'Nieuw Onderdeel' }}
                    </h3>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Merk *
                        </label>
                        <select wire:model.live="selected_brand_id" 
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-2 focus:ring-zinc-500 dark:focus:ring-zinc-400 focus:border-transparent">
                            <option value="">Selecteer een merk</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Model *
                        </label>
                        <select wire:model="device_model_id" 
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-2 focus:ring-zinc-500 dark:focus:ring-zinc-400 focus:border-transparent"
                            {{ !$selected_brand_id ? 'disabled' : '' }}>
                            <option value="">Selecteer een model</option>
                            @foreach($deviceModels as $model)
                                <option value="{{ $model->id }}">{{ $model->name }}</option>
                            @endforeach
                        </select>
                        @error('device_model_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Onderdeel Naam *
                        </label>
                        <input type="text" wire:model="name" 
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-2 focus:ring-zinc-500 dark:focus:ring-zinc-400 focus:border-transparent">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            SKU *
                        </label>
                        <input type="text" wire:model="sku" 
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-2 focus:ring-zinc-500 dark:focus:ring-zinc-400 focus:border-transparent">
                        @error('sku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Beschrijving
                        </label>
                        <textarea wire:model="description" rows="3"
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-2 focus:ring-zinc-500 dark:focus:ring-zinc-400 focus:border-transparent"></textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Prijs *
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-zinc-500">€</span>
                                <input type="number" step="0.01" wire:model="price" 
                                    class="w-full pl-8 pr-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-2 focus:ring-zinc-500 dark:focus:ring-zinc-400 focus:border-transparent">
                            </div>
                            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Voorraad *
                            </label>
                            <input type="number" wire:model="stock" 
                                class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-2 focus:ring-zinc-500 dark:focus:ring-zinc-400 focus:border-transparent">
                            @error('stock') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Min. Voorraad *
                            </label>
                            <input type="number" wire:model="min_stock" 
                                class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-2 focus:ring-zinc-500 dark:focus:ring-zinc-400 focus:border-transparent">
                            @error('min_stock') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" wire:model="is_active" id="is_active_part"
                            class="w-4 h-4 text-zinc-900 bg-zinc-100 border-zinc-300 rounded focus:ring-zinc-500 dark:focus:ring-zinc-600 dark:ring-offset-zinc-800 focus:ring-2 dark:bg-zinc-700 dark:border-zinc-600">
                        <label for="is_active_part" class="ml-2 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                            Actief
                        </label>
                    </div>
                </div>

                <div class="p-6 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-3">
                    <button wire:click="closeModal" type="button" 
                        class="px-4 py-2 bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-600 transition-colors font-medium">
                        Annuleren
                    </button>
                    <button wire:click="save" type="button" 
                        class="px-4 py-2 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-md hover:bg-zinc-700 dark:hover:bg-zinc-100 transition-colors font-medium">
                        {{ $partId ? 'Bijwerken' : 'Aanmaken' }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Stock Adjustment Modal --}}
    @if($showStockModal && $selectedPart)
        <div class="fixed inset-0 bg-zinc-900/50 dark:bg-black/70 flex items-center justify-center p-4 z-50">
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white">
                        Voorraad Aanpassen
                    </h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">{{ $selectedPart->name }}</p>
                </div>

                <div class="p-6 space-y-4">
                    <div class="bg-zinc-50 dark:bg-zinc-900 rounded-lg p-4">
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-1">Huidige voorraad</p>
                        <p class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $selectedPart->stock }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Actie
                        </label>
                        <div class="flex gap-2">
                            <button wire:click="$set('stockOperation', 'add')" type="button"
                                class="flex-1 px-4 py-2 rounded-md font-medium transition-colors {{ $stockOperation === 'add' ? 'bg-green-600 text-white' : 'bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300' }}">
                                Toevoegen
                            </button>
                            <button wire:click="$set('stockOperation', 'subtract')" type="button"
                                class="flex-1 px-4 py-2 rounded-md font-medium transition-colors {{ $stockOperation === 'subtract' ? 'bg-red-600 text-white' : 'bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300' }}">
                                Verlagen
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Aantal
                        </label>
                        <input type="number" wire:model="stockAdjustment" min="1"
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-2 focus:ring-zinc-500 dark:focus:ring-zinc-400 focus:border-transparent">
                        @error('stockAdjustment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    @if($stockAdjustment)
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                            <p class="text-sm text-blue-800 dark:text-blue-300">
                                Nieuwe voorraad: 
                                <span class="font-bold">
                                    {{ $stockOperation === 'add' ? ($selectedPart->stock + (int)$stockAdjustment) : ($selectedPart->stock - (int)$stockAdjustment) }}
                                </span>
                            </p>
                        </div>
                    @endif
                </div>

                <div class="p-6 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-3">
                    <button wire:click="closeModal" type="button" 
                        class="px-4 py-2 bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-600 transition-colors font-medium">
                        Annuleren
                    </button>
                    <button wire:click="adjustStock" type="button" 
                        class="px-4 py-2 {{ $stockOperation === 'add' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }} text-white rounded-md transition-colors font-medium">
                        {{ $stockOperation === 'add' ? 'Toevoegen' : 'Verlagen' }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Delete Modal --}}
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
                                Onderdeel Verwijderen
                            </h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                                Weet je zeker dat je dit onderdeel wilt verwijderen?
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

    {{-- Detail Modal --}}
    @if($showDetailModal && $selectedPart)
        <div class="fixed inset-0 bg-zinc-900/50 dark:bg-black/70 flex items-center justify-center p-4 z-50">
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-1">{{ $selectedPart->deviceModel->brand->name }} {{ $selectedPart->deviceModel->name }}</p>
                            <h3 class="text-xl font-bold text-zinc-900 dark:text-white">
                                {{ $selectedPart->name }}
                            </h3>
                            <span class="inline-block mt-2 text-sm font-medium px-3 py-1 rounded {{ $selectedPart->is_active ? 'bg-green-500/20 text-green-700 dark:text-green-300' : 'bg-red-500/20 text-red-700 dark:text-red-300' }}">
                                {{ $selectedPart->is_active ? 'Actief' : 'Inactief' }}
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
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-zinc-600 dark:text-zinc-400 mb-2">SKU</h4>
                            <p class="text-lg font-mono text-zinc-900 dark:text-white">{{ $selectedPart->sku }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-zinc-600 dark:text-zinc-400 mb-2">Prijs</h4>
                            <p class="text-2xl font-bold text-zinc-900 dark:text-white">€{{ number_format($selectedPart->price, 2, ',', '.') }}</p>
                        </div>
                    </div>

                    @if($selectedPart->description)
                        <div>
                            <h4 class="text-sm font-medium text-zinc-600 dark:text-zinc-400 mb-2">Beschrijving</h4>
                            <p class="text-zinc-900 dark:text-white">{{ $selectedPart->description }}</p>
                        </div>
                    @endif

                    <div class="bg-zinc-50 dark:bg-zinc-900 rounded-lg p-4 border border-zinc-200 dark:border-zinc-700">
                        <h4 class="text-sm font-medium text-zinc-600 dark:text-zinc-400 mb-3">Voorraad Status</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-1">Huidige Voorraad</p>
                                <p class="text-3xl font-bold {{ $selectedPart->isLowStock() ? 'text-amber-600 dark:text-amber-400' : ($selectedPart->isOutOfStock() ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400') }}">
                                    {{ $selectedPart->stock }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-1">Minimale Voorraad</p>
                                <p class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $selectedPart->min_stock }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            @if($selectedPart->isOutOfStock())
                                <div class="flex items-center gap-2 text-red-600 dark:text-red-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span class="font-medium">Uitverkocht</span>
                                </div>
                            @elseif($selectedPart->isLowStock())
                                <div class="flex items-center gap-2 text-amber-600 dark:text-amber-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span class="font-medium">Lage voorraad</span>
                                </div>
                            @else
                                <div class="flex items-center gap-2 text-green-600 dark:text-green-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-medium">Voldoende voorraad</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-3">
                    <button wire:click="closeModal" type="button" 
                        class="px-4 py-2 bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-600 transition-colors font-medium">
                        Sluiten
                    </button>
                    <button wire:click="openStockModal({{ $selectedPart->id }})" type="button" 
                        class="px-4 py-2 bg-blue-600 dark:bg-blue-500 text-white rounded-md hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors font-medium">
                        Voorraad Aanpassen
                    </button>
                    <button wire:click="edit({{ $selectedPart->id }})" type="button" 
                        class="px-4 py-2 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-md hover:bg-zinc-700 dark:hover:bg-zinc-100 transition-colors font-medium">
                        Bewerken
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
