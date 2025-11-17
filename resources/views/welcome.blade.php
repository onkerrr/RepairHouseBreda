<x-landing.layout>
    {{-- Hero Section --}}
    <section class="relative overflow-hidden bg-zinc-900 dark:bg-black text-white">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#4f4f4f2e_1px,transparent_1px),linear-gradient(to_bottom,#4f4f4f2e_1px,transparent_1px)] bg-[size:14px_24px]"></div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-24 sm:py-32">
            <div class="text-center">
                <h1 class="text-4xl font-bold tracking-tight sm:text-6xl mb-6 text-white">
                    Smartphone & Tablet Reparatie in Breda
                </h1>
                <p class="text-lg sm:text-xl text-zinc-300 max-w-2xl mx-auto mb-8">
                    Snel, professioneel en betaalbaar. Van schermreparatie tot batterijvervanging.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#aanbiedingen" class="px-8 py-3 bg-white text-zinc-900 font-semibold rounded-md hover:bg-zinc-100 transition-colors shadow-lg">
                        Bekijk Aanbiedingen
                    </a>
                    <a href="{{ route('register') }}" class="px-8 py-3 bg-zinc-800 text-white font-semibold rounded-md hover:bg-zinc-700 transition-colors border border-zinc-700">
                        Maak een Afspraak
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Actuele Aanbiedingen Section --}}
    <section id="aanbiedingen" class="py-16 bg-white dark:bg-zinc-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-zinc-900 dark:text-white mb-4">
                    Actuele Aanbiedingen
                </h2>
                <p class="text-lg text-zinc-600 dark:text-zinc-400">
                    Profiteer van onze tijdelijke kortingen op reparaties
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $activeOffers = \App\Models\Offer::whereDate('start_date', '<=', now())
                        ->whereDate('end_date', '>=', now())
                        ->with('creator')
                        ->latest()
                        ->take(6)
                        ->get();
                @endphp

                @forelse($activeOffers as $offer)
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow border border-zinc-200 dark:border-zinc-700">
                        <div class="bg-zinc-900 dark:bg-zinc-950 p-4">
                            <div class="flex items-center justify-between">
                                <span class="text-zinc-300 text-sm font-medium px-3 py-1 bg-zinc-800 dark:bg-zinc-900 rounded">
                                    Actief tot {{ $offer->end_date->format('d-m-Y') }}
                                </span>
                                @php
                                    $discount = round((($offer->price_before - $offer->price_after) / $offer->price_before) * 100);
                                @endphp
                                <span class="text-white text-2xl font-bold">
                                    -{{ $discount }}%
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-zinc-900 dark:text-white mb-4">
                                {{ $offer->title }}
                            </h3>
                            
                            <div class="flex items-end gap-3 mb-4">
                                <div class="text-3xl font-bold text-zinc-900 dark:text-white">
                                    €{{ number_format($offer->price_after, 2, ',', '.') }}
                                </div>
                                <div class="text-lg text-zinc-500 dark:text-zinc-400 line-through mb-1">
                                    €{{ number_format($offer->price_before, 2, ',', '.') }}
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between pt-4 border-t border-zinc-200 dark:border-zinc-700">
                                <div class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Nog {{ now()->diffInDays($offer->end_date) }} dagen
                                </div>
                                <a href="{{ route('register') }}" class="text-zinc-900 dark:text-white font-semibold hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                                    Boek nu →
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-zinc-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                        </svg>
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-2">Geen actieve aanbiedingen</h3>
                        <p class="text-zinc-600 dark:text-zinc-400">Check binnenkort weer voor nieuwe deals!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Diensten Section --}}
    <section id="diensten" class="py-16 bg-zinc-50 dark:bg-zinc-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-zinc-900 dark:text-white mb-4">
                    Onze Diensten
                </h2>
                <p class="text-lg text-zinc-600 dark:text-zinc-400">
                    Specialist in alle merken smartphones en tablets
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $services = [
                        ['icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z', 'title' => 'Schermreparatie', 'desc' => 'Van barsten tot complete schermen'],
                        ['icon' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z', 'title' => 'Batterijvervanging', 'desc' => 'Nieuwe batterij, nieuw leven'],
                        ['icon' => 'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z M15 13a3 3 0 11-6 0 3 3 0 016 0z', 'title' => 'Camera Reparatie', 'desc' => 'Voor- en achtercamera'],
                        ['icon' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4', 'title' => 'Water Schade', 'desc' => 'Professionele behandeling'],
                    ];
                @endphp

                @foreach($services as $service)
                    <div class="bg-white dark:bg-zinc-900 rounded-lg p-6 text-center hover:shadow-md transition-shadow border border-zinc-200 dark:border-zinc-700">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-zinc-100 dark:bg-zinc-800 rounded-lg mb-4">
                            <svg class="w-6 h-6 text-zinc-700 dark:text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $service['icon'] }}" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-2">
                            {{ $service['title'] }}
                        </h3>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                            {{ $service['desc'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Openingstijden Section --}}
    <section id="openingstijden" class="py-16 bg-white dark:bg-zinc-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-zinc-900 dark:text-white mb-4">
                        Openingstijden
                    </h2>
                    <p class="text-lg text-zinc-600 dark:text-zinc-400">
                        Loop gewoon binnen of maak een afspraak
                    </p>
                </div>

                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm p-8 border border-zinc-200 dark:border-zinc-700">
                    @php
                        $openingHours = [
                            'Maandag' => '13:00 - 18:00',
                            'Dinsdag' => '10:00 - 18:00',
                            'Woensdag' => '10:00 - 18:00',
                            'Donderdag' => '10:00 - 18:00',
                            'Vrijdag' => '10:00 - 17:00',
                            'Zaterdag' => '10:00 - 17:00',
                            'Zondag' => '12:00 - 17:00',
                        ];
                        $today = now()->locale('nl')->dayName;
                    @endphp

                    <div class="space-y-4">
                        @foreach($openingHours as $day => $hours)
                            <div class="flex items-center justify-between py-3 px-4 rounded {{ $day === $today ? 'bg-zinc-100 dark:bg-zinc-900 border border-zinc-300 dark:border-zinc-600' : 'border-b border-zinc-200 dark:border-zinc-700' }}">
                                <div class="flex items-center gap-3">
                                    @if($day === $today)
                                        <div class="w-2 h-2 bg-zinc-900 dark:bg-white rounded-full"></div>
                                    @endif
                                    <span class="font-semibold text-zinc-900 dark:text-white {{ $day === $today ? 'font-bold' : '' }}">
                                        {{ $day }}
                                    </span>
                                    @if($day === $today)
                                        <span class="text-xs bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 px-2 py-0.5 rounded font-medium">
                                            Vandaag
                                        </span>
                                    @endif
                                </div>
                                <span class="font-medium text-zinc-700 dark:text-zinc-300">
                                    {{ $hours }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Contact/CTA Section --}}
    <section id="contact" class="py-16 bg-zinc-900 dark:bg-black text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4 text-white">
                Klaar om je toestel te laten repareren?
            </h2>
            <p class="text-lg text-zinc-300 mb-8 max-w-2xl mx-auto">
                Maak vandaag nog een afspraak of kom direct langs tijdens onze openingstijden
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-zinc-900 font-semibold rounded-md hover:bg-zinc-100 transition-colors inline-flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Plan Afspraak
                </a>
                <a href="tel:0761234567" class="px-8 py-3 bg-zinc-800 text-white font-semibold rounded-md hover:bg-zinc-700 transition-colors border border-zinc-700 inline-flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    Bel Direct
                </a>
            </div>
        </div>
    </section>
</x-landing.layout>

