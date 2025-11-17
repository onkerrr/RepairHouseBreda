<header class="bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800">
    <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            {{-- Logo --}}
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <x-app-logo class="h-8 w-auto" />
                </a>
            </div>

            {{-- Navigation --}}
            <div class="hidden md:flex items-center space-x-8">
                <a href="#aanbiedingen" class="text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    Aanbiedingen
                </a>
                <a href="#diensten" class="text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    Diensten
                </a>
                <a href="#openingstijden" class="text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    Openingstijden
                </a>
                <a href="#contact" class="text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    Contact
                </a>
            </div>

            {{-- Auth Links --}}
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                        Inloggen
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                        Registreren
                    </a>
                @endauth
            </div>
        </div>
    </nav>
</header>
