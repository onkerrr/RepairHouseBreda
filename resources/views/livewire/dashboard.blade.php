<div>
    <!-- Welcome Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">Dashboard</h1>
        <p class="text-zinc-600 dark:text-zinc-400 mt-2">Welkom terug! Hier is een overzicht van je repair shop.</p>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Pending Appointments -->
        <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                @if($pendingAppointments > 0)
                    <span class="px-3 py-1 bg-white/30 backdrop-blur-sm rounded-full text-sm font-bold">
                        Actie vereist
                    </span>
                @endif
            </div>
            <div class="text-4xl font-bold mb-2">{{ $pendingAppointments }}</div>
            <div class="text-amber-100">In Afwachting</div>
            <a href="{{ route('appointments.index') }}" wire:navigate class="mt-4 inline-flex items-center text-sm font-medium text-white hover:text-amber-100 transition-colors">
                Bekijk afspraken
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <!-- In Progress Appointments -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold mb-2">{{ $confirmedAppointments }}</div>
            <div class="text-blue-100">Bezig</div>
            <a href="{{ route('appointments.index') }}" wire:navigate class="mt-4 inline-flex items-center text-sm font-medium text-white hover:text-blue-100 transition-colors">
                Bekijk afspraken
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <!-- Completed Appointments -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold mb-2">{{ $completedAppointments }}</div>
            <div class="text-green-100">Voltooid</div>
            <a href="{{ route('appointments.index') }}" wire:navigate class="mt-4 inline-flex items-center text-sm font-medium text-white hover:text-green-100 transition-colors">
                Bekijk afspraken
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <!-- Active Offers -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold mb-2">{{ $activeOffers }}</div>
            <div class="text-purple-100">Actieve Aanbiedingen</div>
            <a href="{{ route('offers.index') }}" wire:navigate class="mt-4 inline-flex items-center text-sm font-medium text-white hover:text-purple-100 transition-colors">
                Bekijk aanbiedingen
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>

    <!-- Inventory Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Merken</h3>
                <div class="p-2 bg-zinc-100 dark:bg-zinc-700 rounded-lg">
                    <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-zinc-900 dark:text-white mb-1">{{ $totalBrands }}</div>
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4">Actieve merken</p>
            <a href="{{ route('inventory.brands') }}" wire:navigate class="inline-flex items-center text-sm font-medium text-zinc-900 dark:text-white hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                Beheer merken
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Modellen</h3>
                <div class="p-2 bg-zinc-100 dark:bg-zinc-700 rounded-lg">
                    <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-zinc-900 dark:text-white mb-1">{{ $totalModels }}</div>
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4">Actieve modellen</p>
            <a href="{{ route('inventory.models') }}" wire:navigate class="inline-flex items-center text-sm font-medium text-zinc-900 dark:text-white hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                Beheer modellen
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Onderdelen</h3>
                <div class="p-2 bg-zinc-100 dark:bg-zinc-700 rounded-lg">
                    <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-zinc-900 dark:text-white mb-1">{{ $totalParts }}</div>
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4">Actieve onderdelen</p>
            <a href="{{ route('inventory.parts') }}" wire:navigate class="inline-flex items-center text-sm font-medium text-zinc-900 dark:text-white hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                Beheer onderdelen
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Stock Alerts -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700">
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Voorraad Waarschuwingen</h3>
                    @if($lowStockParts > 0 || $outOfStockParts > 0)
                        <span class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 rounded-full text-sm font-medium">
                            {{ $lowStockParts + $outOfStockParts }} waarschuwingen
                        </span>
                    @endif
                </div>
            </div>

            <div class="p-6">
                @if($lowStockParts > 0 || $outOfStockParts > 0)
                    <div class="space-y-3 mb-4">
                        @if($outOfStockParts > 0)
                            <div class="flex items-center gap-3 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-red-800 dark:text-red-300">{{ $outOfStockParts }} Uitverkocht</p>
                                    <p class="text-xs text-red-600 dark:text-red-400">Onderdelen zijn niet op voorraad</p>
                                </div>
                            </div>
                        @endif

                        @if($lowStockParts > 0)
                            <div class="flex items-center gap-3 p-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-amber-800 dark:text-amber-300">{{ $lowStockParts }} Lage Voorraad</p>
                                    <p class="text-xs text-amber-600 dark:text-amber-400">Onderdelen onder minimale voorraad</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if($lowStockPartsList->count() > 0)
                        <div class="space-y-2">
                            <h4 class="text-sm font-medium text-zinc-900 dark:text-white mb-3">Kritieke Onderdelen</h4>
                            @foreach($lowStockPartsList as $part)
                                <div class="flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-900 rounded-lg">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-zinc-900 dark:text-white truncate">{{ $part->name }}</p>
                                        <p class="text-xs text-zinc-600 dark:text-zinc-400">{{ $part->deviceModel->brand->name }} {{ $part->deviceModel->name }}</p>
                                    </div>
                                    <div class="flex items-center gap-3 ml-4">
                                        <div class="text-right">
                                            <p class="text-sm font-bold {{ $part->isOutOfStock() ? 'text-red-600 dark:text-red-400' : 'text-amber-600 dark:text-amber-400' }}">
                                                {{ $part->stock }}
                                            </p>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">min: {{ $part->min_stock }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('inventory.parts') }}?filter=low_stock" wire:navigate class="inline-flex items-center text-sm font-medium text-zinc-900 dark:text-white hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                            Bekijk alle waarschuwingen
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full mb-4">
                            <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-zinc-900 dark:text-white">Alle onderdelen op voorraad!</p>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400 mt-1">Geen waarschuwingen gevonden</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Appointments -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700">
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Recente Afspraken</h3>
            </div>

            <div class="p-6">
                @if($recentAppointments->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentAppointments as $appointment)
                            <div class="flex items-start gap-3 p-3 bg-zinc-50 dark:bg-zinc-900 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                                <div class="flex-shrink-0 mt-1">
                                    @if($appointment->status === App\AppointmentStatus::Pending)
                                        <div class="w-2 h-2 bg-amber-500 rounded-full"></div>
                                    @elseif($appointment->status === App\AppointmentStatus::InProgress)
                                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                    @elseif($appointment->status === App\AppointmentStatus::Completed)
                                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    @else
                                        <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-zinc-900 dark:text-white truncate">
                                                {{ $appointment->user->name }}
                                            </p>
                                            <p class="text-xs text-zinc-600 dark:text-zinc-400">
                                                {{ $appointment->repairType->name }}
                                            </p>
                                        </div>
                                        <span class="flex-shrink-0 text-xs px-2 py-1 rounded
                                            {{ $appointment->status === App\AppointmentStatus::Pending ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300' : '' }}
                                            {{ $appointment->status === App\AppointmentStatus::InProgress ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300' : '' }}
                                            {{ $appointment->status === App\AppointmentStatus::Completed ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : '' }}
                                            {{ $appointment->status === App\AppointmentStatus::Cancelled ? 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300' : '' }}">
                                            {{ $appointment->status->label() }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                        {{ $appointment->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('appointments.index') }}" wire:navigate class="inline-flex items-center text-sm font-medium text-zinc-900 dark:text-white hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                            Bekijk alle afspraken
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 mx-auto text-zinc-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-sm font-medium text-zinc-900 dark:text-white">Geen afspraken</p>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400 mt-1">Er zijn nog geen afspraken aangemaakt</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8">
        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Snelle Acties</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('appointments.index') }}" wire:navigate class="flex flex-col items-center justify-center p-6 bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 hover:shadow-md hover:border-zinc-300 dark:hover:border-zinc-600 transition-all group">
                <div class="p-3 bg-zinc-100 dark:bg-zinc-700 rounded-full group-hover:bg-zinc-200 dark:group-hover:bg-zinc-600 transition-colors mb-3">
                    <svg class="w-6 h-6 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-zinc-900 dark:text-white">Nieuwe Afspraak</span>
            </a>

            <a href="{{ route('offers.index') }}" wire:navigate class="flex flex-col items-center justify-center p-6 bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 hover:shadow-md hover:border-zinc-300 dark:hover:border-zinc-600 transition-all group">
                <div class="p-3 bg-zinc-100 dark:bg-zinc-700 rounded-full group-hover:bg-zinc-200 dark:group-hover:bg-zinc-600 transition-colors mb-3">
                    <svg class="w-6 h-6 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-zinc-900 dark:text-white">Nieuwe Aanbieding</span>
            </a>

            <a href="{{ route('inventory.parts') }}" wire:navigate class="flex flex-col items-center justify-center p-6 bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 hover:shadow-md hover:border-zinc-300 dark:hover:border-zinc-600 transition-all group">
                <div class="p-3 bg-zinc-100 dark:bg-zinc-700 rounded-full group-hover:bg-zinc-200 dark:group-hover:bg-zinc-600 transition-colors mb-3">
                    <svg class="w-6 h-6 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-zinc-900 dark:text-white">Voorraad Beheren</span>
            </a>

            <a href="{{ route('inventory.brands') }}" wire:navigate class="flex flex-col items-center justify-center p-6 bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 hover:shadow-md hover:border-zinc-300 dark:hover:border-zinc-600 transition-all group">
                <div class="p-3 bg-zinc-100 dark:bg-zinc-700 rounded-full group-hover:bg-zinc-200 dark:group-hover:bg-zinc-600 transition-colors mb-3">
                    <svg class="w-6 h-6 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-zinc-900 dark:text-white">Nieuw Merk</span>
            </a>
        </div>
    </div>
</div>
