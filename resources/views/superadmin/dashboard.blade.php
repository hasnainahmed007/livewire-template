<x-layouts::superadmin :title="__('Superadmin Dashboard')">
    <div class="mb-6 flex flex-wrap items-start justify-between gap-3">
        <div>
            <h1 class="text-xl font-semibold">{{ __('Superadmin Dashboard') }}</h1>
            <p class="mt-1 text-sm text-ink/60">{{ __('Welcome back, :name', ['name' => auth()->user()->name]) }}</p>
        </div>
        <x-tenant.status-dot state="neutral" :label="auth()->user()->getRoleNames()->first() ?? __('no role')" />
    </div>

    @if (session('success'))
        <p role="status" class="mb-4 rounded-md border border-line bg-surface px-4 py-2.5 text-sm">{{ session('success') }}</p>
    @endif

    <div class="grid gap-4 md:grid-cols-3">
        <section aria-labelledby="platform-staff" class="rounded-lg border border-line bg-surface p-4">
            <h2 id="platform-staff" class="text-sm font-semibold">{{ __('Staff') }}</h2>
            <p class="mt-1 text-sm text-ink/60">{{ __('Manage admin and manager users.') }}</p>
            <a href="{{ route('superadmin.staff.index') }}" wire:navigate class="mt-4 inline-flex items-center rounded-md bg-brand px-4 py-2 text-sm font-medium text-white hover:bg-brand-deep">{{ __('View staff') }}</a>
        </section>
        <section aria-labelledby="platform-roles" class="rounded-lg border border-line bg-surface p-4">
            <h2 id="platform-roles" class="text-sm font-semibold">{{ __('Roles') }}</h2>
            <p class="mt-1 text-sm text-ink/60">{{ __('Manage roles and their permissions.') }}</p>
            <a href="{{ route('superadmin.roles.index') }}" wire:navigate class="mt-4 inline-flex items-center rounded-md bg-brand px-4 py-2 text-sm font-medium text-white hover:bg-brand-deep">{{ __('View roles') }}</a>
        </section>
        <section aria-labelledby="platform-permissions" class="rounded-lg border border-line bg-surface p-4">
            <h2 id="platform-permissions" class="text-sm font-semibold">{{ __('Permissions') }}</h2>
            <p class="mt-1 text-sm text-ink/60">{{ __('Assign roles to users.') }}</p>
            <a href="{{ route('superadmin.permissions.index') }}" wire:navigate class="mt-4 inline-flex items-center rounded-md bg-brand px-4 py-2 text-sm font-medium text-white hover:bg-brand-deep">{{ __('View permissions') }}</a>
        </section>
    </div>
</x-layouts::superadmin>
