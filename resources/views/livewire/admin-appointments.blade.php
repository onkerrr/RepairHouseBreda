<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($appointments as $appointment)
        <div
            class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 shadow-sm hover:shadow-md transition">
            <div class="p-4 flex flex-col gap-2">

                {{-- Header: repair type + status badge --}}
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ $appointment->repairType?->name ?? 'Onbekend' }}
                    </h3>

                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'in_progress' => 'bg-blue-100 text-blue-800',
                            'completed' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                        ];
                    @endphp

                    <span
                        class="text-sm font-medium px-2 py-1 rounded-full {{ $statusColors[$appointment->status->value] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ str_replace('_', ' ', $appointment->status->value) }}
                    </span>

                </div>

                {{-- Issue description --}}
                <p class="text-sm text-gray-500 dark:text-gray-300 line-clamp-3">
                    {{ $appointment->issue_description ?? 'Geen beschrijving' }}
                </p>

                {{-- User & date --}}
                <div class="flex justify-between items-center mt-2 text-sm text-gray-600 dark:text-gray-400">
                    <span>Gebruiker: {{ $appointment->user?->name ?? 'Onbekend' }}</span>
                    <span>{{ $appointment->appointment_date }}</span>
                </div>

                {{-- Estimated duration --}}
                <div class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Geschatte duur: {{ $appointment->estimated_repair_duration ?? '-' }} min
                </div>
            </div>
        </div>
    @empty
        <p class="col-span-3 text-center text-gray-400">Geen afspraken gevonden.</p>
    @endforelse
</div>
