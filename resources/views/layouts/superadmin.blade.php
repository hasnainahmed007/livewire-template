<x-layouts::superadmin.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts::superadmin.sidebar>
