{{-- Role-aware shell for account settings pages (profile, appearance, security).
     Livewire's #[Layout] is static, so this layout renders the full document
     of the panel the signed-in user belongs to. Only one branch renders,
     so scripts and markup are never nested or duplicated. --}}
@if (auth()->user()?->belongsToSuperadminPanel())
    <x-layouts::superadmin :title="$title ?? null">
        {{ $slot }}
    </x-layouts::superadmin>
@elseif (auth()->user()?->belongsToTenantPanel())
    <x-layouts::tenant :title="$title ?? null">
        {{ $slot }}
    </x-layouts::tenant>
@else
    <x-layouts::app :title="$title ?? null">
        {{ $slot }}
    </x-layouts::app>
@endif
