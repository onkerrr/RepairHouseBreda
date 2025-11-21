<div>
    @if (session()->has('message'))
        <div class="mb-4 rounded-lg bg-green-50 dark:bg-green-900/20 p-4 text-sm text-green-800 dark:text-green-400 border border-green-200 dark:border-green-800">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">Merken Beheer</h2>
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Beheer alle apparaat merken</p>
        </div>
        <button wire:click="create" class="inline-flex items-center px-4 py-2 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-semibold rounded-md hover:bg-zinc-700 dark:hover:bg-zinc-100 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nieuw Merk
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
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($brands as $brand)
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                            {{ $brand->name }}
                        </h3>
                        <span class="text-sm font-medium px-3 py-1 rounded {{ $brand->is_active ? 'bg-green-500/20 text-green-700 dark:text-green-300' : 'bg-red-500/20 text-red-700 dark:text-red-300' }}">
                            {{ $brand->is_active ? 'Actief' : 'Inactief' }}
                        </span>
                    </div>

                    @if($brand->description)
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4 line-clamp-2">
                            {{ $brand->description }}
                        </p>
                    @else
                        <p class="text-sm text-zinc-400 dark:text-zinc-500 mb-4 italic">
                            Geen beschrijving
                        </p>
                    @endif

                    <div class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400 mb-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        {{ $brand->device_models_count }} {{ $brand->device_models_count === 1 ? 'model' : 'modellen' }}
                    </div>

                    <div class="flex gap-2 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                        <button wire:click="show({{ $brand->id }})" class="flex-1 px-3 py-2 bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-600 transition-colors text-sm font-medium">
                            Bekijken
                        </button>
                        <button wire:click="edit({{ $brand->id }})" class="flex-1 px-3 py-2 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-md hover:bg-zinc-700 dark:hover:bg-zinc-100 transition-colors text-sm font-medium">
                            Bewerken
                        </button>
                        <button wire:click="confirmDelete({{ $brand->id }})" class="px-3 py-2 bg-red-600 dark:bg-red-500 text-white rounded-md hover:bg-red-700 dark:hover:bg-red-600 transition-colors">
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
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-2">Geen merken gevonden</h3>
                <p class="text-zinc-600 dark:text-zinc-400 mb-4">
                    @if($filterStatus === 'all')
                        Er zijn nog geen merken aangemaakt.
                    @else
                        Geen merken met status "{{ ucfirst($filterStatus) }}".
                    @endif
                </p>
            </div>
        @endforelse
    </div>

    {{-- Create/Edit Modal --}}
    @if($showModal)
        <div class="fixed inset-0 bg-zinc-900/50 dark:bg-black/70 flex items-center justify-center p-4 z-50">
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white">
                        {{ $brandId ? 'Merk Bewerken' : 'Nieuw Merk' }}
                    </h3>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Naam *
                        </label>
                        <input type="text" wire:model="name" 
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-2 focus:ring-zinc-500 dark:focus:ring-zinc-400 focus:border-transparent">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Beschrijving
                        </label>
                        <textarea wire:model="description" rows="3"
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-2 focus:ring-zinc-500 dark:focus:ring-zinc-400 focus:border-transparent"></textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" wire:model="is_active" id="is_active"
                            class="w-4 h-4 text-zinc-900 bg-zinc-100 border-zinc-300 rounded focus:ring-zinc-500 dark:focus:ring-zinc-600 dark:ring-offset-zinc-800 focus:ring-2 dark:bg-zinc-700 dark:border-zinc-600">
                        <label for="is_active" class="ml-2 text-sm font-medium text-zinc-700 dark:text-zinc-300">
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
                        {{ $brandId ? 'Bijwerken' : 'Aanmaken' }}
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
                                Merk Verwijderen
                            </h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                                Weet je zeker dat je dit merk wilt verwijderen? Alle gerelateerde modellen en onderdelen worden ook verwijderd.
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
    @if($showDetailModal && $selectedBrand)
        <div class="fixed inset-0 bg-zinc-900/50 dark:bg-black/70 flex items-center justify-center p-4 z-50">
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-zinc-900 dark:text-white">
                                {{ $selectedBrand->name }}
                            </h3>
                            <span class="inline-block mt-2 text-sm font-medium px-3 py-1 rounded {{ $selectedBrand->is_active ? 'bg-green-500/20 text-green-700 dark:text-green-300' : 'bg-red-500/20 text-red-700 dark:text-red-300' }}">
                                {{ $selectedBrand->is_active ? 'Actief' : 'Inactief' }}
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
                    @if($selectedBrand->description)
                        <div>
                            <h4 class="text-sm font-medium text-zinc-600 dark:text-zinc-400 mb-2">Beschrijving</h4>
                            <p class="text-zinc-900 dark:text-white">{{ $selectedBrand->description }}</p>
                        </div>
                    @endif

                    <div>
                        <h4 class="text-sm font-medium text-zinc-600 dark:text-zinc-400 mb-3">Modellen ({{ $selectedBrand->device_models_count }})</h4>
                        @if($selectedBrand->deviceModels->count() > 0)
                            <div class="space-y-2">
                                @foreach($selectedBrand->deviceModels as $model)
                                    <div class="flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-900 rounded-lg">
                                        <div>
                                            <p class="font-medium text-zinc-900 dark:text-white">{{ $model->name }}</p>
                                            <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $model->parts_count }} {{ $model->parts_count === 1 ? 'onderdeel' : 'onderdelen' }}</p>
                                        </div>
                                        <span class="text-sm font-medium px-3 py-1 rounded {{ $model->is_active ? 'bg-green-500/20 text-green-700 dark:text-green-300' : 'bg-red-500/20 text-red-700 dark:text-red-300' }}">
                                            {{ $model->is_active ? 'Actief' : 'Inactief' }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-zinc-500 dark:text-zinc-400 text-sm italic">Geen modellen gevonden</p>
                        @endif
                    </div>
                </div>

                <div class="p-6 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-3">
                    <button wire:click="closeModal" type="button" 
                        class="px-4 py-2 bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-600 transition-colors font-medium">
                        Sluiten
                    </button>
                    <button wire:click="edit({{ $selectedBrand->id }})" type="button" 
                        class="px-4 py-2 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-md hover:bg-zinc-700 dark:hover:bg-zinc-100 transition-colors font-medium">
                        Bewerken
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
