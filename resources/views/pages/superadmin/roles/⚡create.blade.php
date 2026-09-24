<?php

use Flux\Flux;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

new #[Title('Create Role'), Layout('layouts::superadmin')] class extends Component {
    use AuthorizesRequests;

    public string $name = '';
    public array $permissions = [];

    #[Computed]
    public function availablePermissions(): Collection
    {
        return Permission::where('guard_name', 'web')->orderBy('name')->pluck('name');
    }

    public function save(): void
    {
        $this->authorize('roles.create');

        $validated = $this->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'string',
        ]);

        foreach ($validated['permissions'] as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
        }

        $role = Role::create([
            'name' => str($validated['name'])->lower()->replace(' ', '')->toString(),
            'guard_name' => 'web',
        ]);

        $role->syncPermissions($validated['permissions']);

        Flux::toast(variant: 'success', text: __('Role created successfully.'));

        $this->redirect(route('superadmin.roles.index', absolute: false), navigate: true);
    }
}; ?>

<div class="flex h-full w-full flex-1 flex-col gap-4">
    <flux:heading size="xl">{{ __('Create role') }}</flux:heading>

    <flux:card class="max-w-2xl">
        <form wire:submit="save" class="flex flex-col gap-4">
            <flux:field>
                <flux:label>{{ __('Name') }}</flux:label>
                <flux:input wire:model="name" required placeholder="e.g. accountant" />
                <flux:error name="name" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Permissions') }}</flux:label>
                <div class="grid gap-2 md:grid-cols-2">
                    @foreach ($this->availablePermissions as $permission)
                        <flux:checkbox wire:model="permissions" :value="$permission" :label="$permission" />
                    @endforeach
                </div>
                <flux:error name="permissions" />
            </flux:field>

            <div class="flex gap-2">
                <flux:button variant="primary" type="submit">{{ __('Save') }}</flux:button>
                <flux:button variant="ghost" :href="route('superadmin.roles.index')" wire:navigate>{{ __('Cancel') }}</flux:button>
            </div>
        </form>
    </flux:card>
</div>
