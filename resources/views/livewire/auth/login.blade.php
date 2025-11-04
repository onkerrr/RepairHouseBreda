<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Log in op je account')" :description="__('Voer uw email en wachtwoord in om in te loggen')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email addres')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@voorbeeld.nl"
        />

        <!-- Password -->
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="__('Wachtwoord')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Wachtwoord')"
                viewable
            />

            @if (Route::has('password.request'))
                <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                    {{ __('Wachtwoord vergeten?') }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" :label="__('Gegevens bewaren')" />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                {{ __('Log in') }}
            </flux:button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Heeft u nog geen account?') }}</span>
            <flux:link :href="route('register')" wire:navigate>{{ __('Registreer') }}</flux:link>
        </div>
    @endif
</div>
