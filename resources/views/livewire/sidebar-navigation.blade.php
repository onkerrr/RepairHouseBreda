<div>
    <flux:navlist variant="outline">
        <flux:navlist.group :heading="__('Platform')" class="grid">
            <flux:navlist.item 
                icon="home" 
                :href="route('dashboard')" 
                :current="request()->routeIs('dashboard')" 
                wire:navigate
            >
                {{ __('Dashboard') }}
            </flux:navlist.item>

            <flux:navlist.item 
                icon="calendar" 
                :href="route('appointments.index')" 
                :current="request()->routeIs('appointments.*')" 
                wire:navigate
            >
                <div class="flex items-center justify-between w-full">
                    <span>{{ __('Afspraken') }}</span>
                    @if($pendingCount > 0)
                        <flux:badge size="sm" color="amber" class="ml-auto">
                            {{ $pendingCount }}
                        </flux:badge>
                    @endif
                </div>
            </flux:navlist.item>

            <flux:navlist.item 
                icon="tag" 
                :href="route('offers.index')" 
                :current="request()->routeIs('offers.*')" 
                wire:navigate
            >
                {{ __('Aanbiedingen') }}
            </flux:navlist.item>
        </flux:navlist.group>
    </flux:navlist>
</div>
