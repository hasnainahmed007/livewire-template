<?php

use App\Models\User;
use Flux\Flux;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Role;

new #[Title('Permissions'), Layout('layouts::superadmin')] class extends Component {
    use AuthorizesRequests;

    public string $search = '';
    public array $selectedRoles = [];

    public function mount(): void
    {
        $this->authorize('permissions.read');

        $this->syncSelectedRoles();
    }

    #[Computed]
    public function users(): Collection
    {
        $this->authorize('permissions.read');

        return User::with('roles')
            ->when($this->search !== '', fn ($query) => $query
            ->where(fn ($q) => $q->where('name', 'like', '%'.$this->search.'%')
            ->orWhere('email', 'like', '%'.$this->search.'%')))
            ->orderBy('name')
            ->get();
    }

    #[Computed]
    public function roles(): Collection
    {
        return Role::where('guard_name', 'web')->orderBy('name')->get();
    }

    public function assign(int $userId): void
    {
        $this->authorize('permissions.edit');

        $this->validate([
            "selectedRoles.{$userId}" => 'required|string|exists:roles,name',
        ]);

        $user = User::findOrFail($userId);
        $user->syncRoles([$this->selectedRoles[$userId]]);

        unset($this->users);

        Flux::toast(variant: 'success', text: __('Role assigned to user successfully.'));
    }

    public function remove(int $userId): void
    {
        $this->authorize('permissions.edit');

        User::findOrFail($userId)->syncRoles([]);

        $this->syncSelectedRoles();
        unset($this->users);

        Flux::toast(variant: 'success', text: __('Role removed from user successfully.'));
    }

    private function syncSelectedRoles(): void
    {
        $this->selectedRoles = User::with('roles')->get()->mapWithKeys(fn (User $user) => [
            $user->id => $user->roles->first()?->name ?? '',
        ])->toArray();
    }
}; ?>

<div class="flex h-full w-full flex-1 flex-col gap-4">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <flux:heading size="xl">{{ __('Permissions') }}</flux:heading>
            <flux:text>{{ __('Assign roles to users.') }}</flux:text>
        </div>
        <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="{{ __('Search users...') }}" />
    </div>

    <flux:card>
        <flux:table>
            <flux:table.columns>
                <flux:table.column>{{ __('User') }}</flux:table.column>
                <flux:table.column>{{ __('Email') }}</flux:table.column>
                <flux:table.column>{{ __('Roles') }}</flux:table.column>
                <flux:table.column align="end">{{ __('Actions') }}</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @forelse ($this->users as $user)
                    <flux:table.row :key="$user->id">
                        <flux:table.cell>{{ $user->name }}</flux:table.cell>
                        <flux:table.cell>{{ $user->email }}</flux:table.cell>
                        <flux:table.cell>
                            @foreach ($user->roles as $role)
                                <flux:badge color="zinc">{{ $role->name }}</flux:badge>
                            @endforeach
                        </flux:table.cell>
                        <flux:table.cell align="end">
                            <div class="flex justify-end gap-2">
                                @can('permissions.edit')
                                    <flux:select wire:model="selectedRoles.{{ $user->id }}" size="sm">
                                        <flux:select.option value="">{{ __('Select role...') }}</flux:select.option>
                                        @foreach ($this->roles as $role)
                                            <flux:select.option value="{{ $role->name }}">{{ $role->name }}</flux:select.option>
                                        @endforeach
                                    </flux:select>
                                    <flux:button size="sm" variant="primary" wire:click="assign({{ $user->id }})">{{ __('Assign') }}</flux:button>
                                    <flux:button size="sm" variant="danger" wire:click="remove({{ $user->id }})">{{ __('Remove') }}</flux:button>
                                @endcan
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="4">{{ __('No users found.') }}</flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>
