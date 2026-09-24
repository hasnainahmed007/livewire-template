<?php

use Flux\Flux;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Role;

new #[Title('Roles'), Layout('layouts::superadmin')] class extends Component {
    use AuthorizesRequests;

    public string $search = '';

    public bool $confirmingDeletion = false;

    public ?int $deletingRoleId = null;

    #[Computed]
    public function roles(): Collection
    {
        $this->authorize('roles.read');

        return Role::where('guard_name', 'web')
            ->withCount(['users', 'permissions'])
            ->when($this->search !== '', fn ($query) => $query->where('name', 'like', '%'.$this->search.'%'))
            ->orderBy('name')
            ->get();
    }

    public function confirmDelete(int $roleId): void
    {
        $this->authorize('roles.delete');

        $this->deletingRoleId = $roleId;
        $this->confirmingDeletion = true;
    }

    public function cancelDelete(): void
    {
        $this->confirmingDeletion = false;
        $this->deletingRoleId = null;
    }

    public function deleteRole(): void
    {
        $this->authorize('roles.delete');

        Role::where('guard_name', 'web')->findOrFail($this->deletingRoleId)->delete();

        unset($this->roles);

        $this->cancelDelete();

        Flux::toast(variant: 'success', text: __('Role deleted successfully.'));
    }
}; ?>

<div class="flex h-full w-full flex-1 flex-col gap-4">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <flux:heading size="xl">{{ __('Roles') }}</flux:heading>
            <flux:text>{{ __('Manage roles and their permissions.') }}</flux:text>
        </div>

        <div class="flex flex-col gap-2 md:flex-row md:items-center">
            <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="{{ __('Search roles...') }}" />
            @can('roles.create')
                <flux:button variant="primary" :href="route('superadmin.roles.create')" wire:navigate>{{ __('Create role') }}</flux:button>
            @endcan
        </div>
    </div>

    <flux:card>
        <flux:table>
            <flux:table.columns>
                <flux:table.column>{{ __('Name') }}</flux:table.column>
                <flux:table.column>{{ __('Permissions') }}</flux:table.column>
                <flux:table.column>{{ __('Users') }}</flux:table.column>
                <flux:table.column align="end">{{ __('Actions') }}</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @forelse ($this->roles as $role)
                    <flux:table.row :key="$role->id">
                        <flux:table.cell><flux:badge color="zinc">{{ $role->name }}</flux:badge></flux:table.cell>
                        <flux:table.cell>{{ $role->permissions_count }}</flux:table.cell>
                        <flux:table.cell>{{ $role->users_count }}</flux:table.cell>
                        <flux:table.cell align="end">
                            <div class="flex justify-end gap-2">
                                @can('roles.edit')
                                    <flux:button size="sm" variant="ghost" :href="route('superadmin.roles.edit', $role)" wire:navigate>{{ __('Edit') }}</flux:button>
                                @endcan
                                @can('roles.delete')
                                    <flux:button size="sm" variant="danger" wire:click="confirmDelete({{ $role->id }})">{{ __('Delete') }}</flux:button>
                                @endcan
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="4">{{ __('No roles found.') }}</flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>

    <flux:modal wire:model="confirmingDeletion" class="max-w-md">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Delete role?') }}</flux:heading>
                <flux:text>{{ __('This action cannot be undone.') }}</flux:text>
            </div>

            <div class="flex justify-end gap-2">
                <flux:button variant="ghost" wire:click="cancelDelete">{{ __('Cancel') }}</flux:button>
                <flux:button variant="danger" wire:click="deleteRole">{{ __('Delete') }}</flux:button>
            </div>
        </div>
    </flux:modal>
</div>