<div class="space-y-6">
    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div class="bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">Afspraken</h1>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                Beheer alle reparatie afspraken
            </p>
        </div>
        <button 
            wire:click="create"
            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors flex items-center gap-2"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nieuwe afspraak
        </button>
    </div>

    {{-- Status Filter --}}
    <div class="flex gap-2 flex-wrap">
        <button 
            wire:click="$set('statusFilter', 'all')" 
            class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $statusFilter === 'all' ? 'bg-blue-600 text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}"
        >
            Alle ({{ $this->appointments->count() }})
        </button>
        <button 
            wire:click="$set('statusFilter', 'pending')" 
            class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $statusFilter === 'pending' ? 'bg-blue-600 text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}"
        >
            In afwachting
        </button>
        <button 
            wire:click="$set('statusFilter', 'in_progress')" 
            class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $statusFilter === 'in_progress' ? 'bg-blue-600 text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}"
        >
            Bezig
        </button>
        <button 
            wire:click="$set('statusFilter', 'completed')" 
            class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $statusFilter === 'completed' ? 'bg-blue-600 text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}"
        >
            Voltooid
        </button>
        <button 
            wire:click="$set('statusFilter', 'cancelled')" 
            class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $statusFilter === 'cancelled' ? 'bg-blue-600 text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}"
        >
            Geannuleerd
        </button>
    </div>

    {{-- Appointments Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($this->appointments as $appointment)
            <div class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl p-5 hover:shadow-lg transition-shadow">
                {{-- Header with repair type --}}
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-1">
                            {{ $appointment->repairType?->brand ?? 'Onbekend merk' }}
                        </h3>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                            {{ $appointment->repairType?->description ?? 'Geen beschrijving' }}
                        </p>
                    </div>
                </div>

                {{-- Status Badge --}}
                <div class="mb-3 flex gap-2">
                    @php
                        $statusColor = match($appointment->status) {
                            App\AppointmentStatus::Pending => 'bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-200',
                            App\AppointmentStatus::InProgress => 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200',
                            App\AppointmentStatus::Completed => 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200',
                            App\AppointmentStatus::Cancelled => 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200',
                            default => 'bg-zinc-100 dark:bg-zinc-700 text-zinc-800 dark:text-zinc-200',
                        };
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                        {{ $appointment->status->label() }}
                    </span>
                    
                    @if($appointment->sub_status)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-violet-100 dark:bg-violet-900/30 text-violet-800 dark:text-violet-200">
                            {{ $appointment->sub_status->label() }}
                        </span>
                    @endif
                </div>

                {{-- Issue Description --}}
                @if($appointment->issue_description)
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-3 line-clamp-2">
                        {{ $appointment->issue_description }}
                    </p>
                @endif

                <div class="border-t border-zinc-200 dark:border-zinc-700 my-3"></div>

                {{-- User Info --}}
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                        {{ $appointment->user?->name ?? 'Geen account' }}
                    </span>
                </div>

                {{-- Date Info --}}
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                        {{ $appointment->appointment_date->format('d-m-Y H:i') }}
                    </span>
                </div>

                {{-- Duration --}}
                @if($appointment->estimated_repair_duration)
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">
                            {{ $appointment->estimated_repair_duration }} minuten
                        </span>
                    </div>
                @endif

                {{-- UUID (klein en subtiel) --}}
                <div class="mt-3 pt-3 border-t border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                    <span class="text-xs text-zinc-400 font-mono">
                        {{ Str::lower($appointment->uuid) }}
                    </span>
                    
                    {{-- Action buttons --}}
                    <div class="flex gap-2">
                        <button 
                            type="button"
                            wire:click="edit({{ $appointment->id }})"
                            class="p-1.5 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded transition-colors"
                            title="Bewerken"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button 
                            type="button"
                            wire:click="confirmDelete({{ $appointment->id }})"
                            class="p-1.5 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded transition-colors"
                            title="Verwijderen"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl p-12">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto text-zinc-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-1">Geen afspraken gevonden</h3>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">Er zijn geen afspraken met deze status</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Create/Edit Modal --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 text-center">
            {{-- Background overlay --}}
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" wire:click="closeModal"></div>
            
            {{-- Modal panel --}}
            <div class="relative bg-white dark:bg-zinc-800 rounded-lg text-left overflow-hidden shadow-xl max-w-2xl w-full z-10">
                <form wire:submit.prevent="save">
                        <div class="bg-white dark:bg-zinc-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-4">
                                {{ $editingAppointmentId ? 'Afspraak bewerken' : 'Nieuwe afspraak' }}
                            </h3>

                            <div class="space-y-4">
                                {{-- User --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                        Klant (optioneel)
                                    </label>
                                    <select wire:model="user_id" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100">
                                        <option value="">Geen account (walk-in)</option>
                                        @foreach($this->users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                        @endforeach
                                    </select>
                                    @error('user_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                {{-- Repair Type --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                        Reparatie type *
                                    </label>
                                    <select wire:model="repair_type_id" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100" required>
                                        <option value="">Selecteer reparatie type</option>
                                        @foreach($this->repairTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->brand }} - {{ $type->description }}</option>
                                        @endforeach
                                    </select>
                                    @error('repair_type_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                {{-- Appointment Date --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                        Datum & tijd *
                                    </label>
                                    <input type="datetime-local" wire:model="appointment_date" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100" required>
                                    @error('appointment_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                {{-- Issue Description --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                        Probleem beschrijving
                                    </label>
                                    <textarea wire:model="issue_description" rows="3" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100"></textarea>
                                    @error('issue_description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                {{-- Status --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                        Status *
                                    </label>
                                    <select wire:model.live="status" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100" required>
                                        <option value="pending">In afwachting</option>
                                        <option value="in_progress">Bezig</option>
                                        <option value="completed">Voltooid</option>
                                        <option value="cancelled">Geannuleerd</option>
                                    </select>
                                    @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                {{-- Sub Status (only for in_progress) --}}
                                @if($status === 'in_progress')
                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                            Sub-status
                                        </label>
                                        <select wire:model="sub_status" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100">
                                            <option value="">Geen sub-status</option>
                                            <option value="waiting_for_parts">Wachten op onderdelen</option>
                                            <option value="contact_customer">Klant contacteren</option>
                                            <option value="cancelled_repair">Reparatie geannuleerd</option>
                                        </select>
                                        @error('sub_status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                @endif

                                {{-- Estimated Duration --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                        Geschatte duur (minuten)
                                    </label>
                                    <input type="number" wire:model="estimated_repair_duration" min="1" max="480" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100">
                                    @error('estimated_repair_duration') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="bg-zinc-50 dark:bg-zinc-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                            <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                {{ $editingAppointmentId ? 'Opslaan' : 'Aanmaken' }}
                            </button>
                            <button type="button" wire:click="closeModal" class="mt-3 sm:mt-0 w-full sm:w-auto px-4 py-2 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 text-zinc-700 dark:text-zinc-300 font-medium rounded-lg border border-zinc-300 dark:border-zinc-600 transition-colors">
                                Annuleren
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Delete Confirmation Modal --}}
    @if($showDeleteModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 text-center">
            {{-- Background overlay --}}
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" wire:click="closeDeleteModal"></div>
            
            {{-- Modal panel --}}
            <div class="relative bg-white dark:bg-zinc-800 rounded-lg text-left overflow-hidden shadow-xl max-w-lg w-full z-10">
                    <div class="bg-white dark:bg-zinc-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-zinc-900 dark:text-zinc-100">
                                    Afspraak verwijderen
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                        Weet je zeker dat je deze afspraak wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button wire:click="delete" class="w-full sm:w-auto px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                            Verwijderen
                        </button>
                        <button wire:click="closeDeleteModal" class="mt-3 sm:mt-0 w-full sm:w-auto px-4 py-2 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 text-zinc-700 dark:text-zinc-300 font-medium rounded-lg border border-zinc-300 dark:border-zinc-600 transition-colors">
                            Annuleren
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
