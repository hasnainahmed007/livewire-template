<x-layouts::superadmin :title="__('Superadmin Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">{{ __('Superadmin Dashboard') }}</flux:heading>
                <flux:text>{{ __('Welcome back, :name (:role)', ['name' => auth()->user()->name, 'role' => auth()->user()->getRoleNames()->first() ?? 'no role']) }}</flux:text>
            </div>
            <flux:badge color="zinc">{{ auth()->user()->getRoleNames()->first() ?? 'no role' }}</flux:badge>
        </div>

        @if (session('success'))
            <flux:callout variant="success" :heading="session('success')" />
        @endif

        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <flux:card>
                <flux:heading>{{ __('Staff') }}</flux:heading>
                <flux:text>{{ __('Manage admin and manager users.') }}</flux:text>
                <flux:button variant="primary" :href="route('superadmin.staff.index')" wire:navigate class="mt-4">{{ __('View staff') }}</flux:button>
            </flux:card>
            <flux:card>
                <flux:heading>{{ __('Roles') }}</flux:heading>
                <flux:text>{{ __('Manage roles and their permissions.') }}</flux:text>
                <flux:button variant="primary" :href="route('superadmin.roles.index')" wire:navigate class="mt-4">{{ __('View roles') }}</flux:button>
            </flux:card>
            <flux:card>
                <flux:heading>{{ __('Permissions') }}</flux:heading>
                <flux:text>{{ __('Assign roles to users.') }}</flux:text>
                <flux:button variant="primary" :href="route('superadmin.permissions.index')" wire:navigate class="mt-4">{{ __('View permissions') }}</flux:button>
            </flux:card>
        </div>
    </div>
</x-layouts::superadmin>
