<?php

use App\Models\User;
use Flux\Flux;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Staff')] class extends Component {
    use AuthorizesRequests;

    public string $search = '';

    public bool $confirmingDeletion = false;

    public ?int $deletingStaffId = null;

    #[Computed]
    public function staff(): Collection
    {
        $this->authorize('staff.read');

        return User::with('roles')
            ->whereHas('roles', fn ($query) => $query->whereIn('name', ['admin', 'manager']))
            ->when($this->search !== '', fn ($query) => $query
            ->where(fn ($q) => $q->where('name', 'like', '%'.$this->search.'%')
            ->orWhere('email', 'like', '%'.$this->search.'%')))
            ->orderBy('name')
            ->get();
    }

    public function confirmDelete(int $staffId): void
    {
        $this->authorize('staff.delete');

        $this->deletingStaffId = $staffId;
        $this->confirmingDeletion = true;
    }

    public function cancelDelete(): void
    {
        $this->confirmingDeletion = false;
        $this->deletingStaffId = null;
    }

    public function deleteStaff(): void
    {
        $this->authorize('staff.delete');

        $staff = User::findOrFail($this->deletingStaffId);
        $staff->syncRoles([]);
        $staff->delete();

        unset($this->staff);

        $this->cancelDelete();

        Flux::toast(variant: 'success', text: __('Staff member deleted successfully.'));
    }
}; ?>

<div class="flex h-full w-full flex-1 flex-col gap-4">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <flux:heading size="xl">{{ __('Staff') }}</flux:heading>
            <flux:text>{{ __('Manage admin and manager users.') }}</flux:text>
        </div>

        <div class="flex flex-col gap-2 md:flex-row md:items-center">
            <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="{{ __('Search staff...') }}" />
            @can('staff.create')
                <flux:button variant="primary" :href="route('superadmin.staff.create')" wire:navigate>{{ __('Create staff') }}</flux:button>
            @endcan
        </div>
    </div>

    <flux:card>
        <flux:table>
            <flux:table.columns>
                <flux:table.column>{{ __('Name') }}</flux:table.column>
                <flux:table.column>{{ __('Email') }}</flux:table.column>
                <flux:table.column>{{ __('Role') }}</flux:table.column>
                <flux:table.column align="end">{{ __('Actions') }}</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @forelse ($this->staff as $member)
                    <flux:table.row :key="$member->id">
                        <flux:table.cell>{{ $member->name }}</flux:table.cell>
                        <flux:table.cell>{{ $member->email }}</flux:table.cell>
                        <flux:table.cell><flux:badge color="zinc">{{ $member->roles->first()?->name ?? '—' }}</flux:badge></flux:table.cell>
                        <flux:table.cell align="end">
                            <div class="flex justify-end gap-2">
                                @can('staff.edit')
                                    <flux:button size="sm" variant="ghost" :href="route('superadmin.staff.edit', $member)" wire:navigate>{{ __('Edit') }}</flux:button>
                                @endcan
                                @can('staff.delete')
                                    <flux:button size="sm" variant="danger" wire:click="confirmDelete({{ $member->id }})">{{ __('Delete') }}</flux:button>
                                @endcan
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="4">{{ __('No staff found.') }}</flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>

    <flux:modal wire:model="confirmingDeletion" class="max-w-md">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Delete staff member?') }}</flux:heading>
                <flux:text>{{ __('This action cannot be undone.') }}</flux:text>
            </div>

            <div class="flex justify-end gap-2">
                <flux:button variant="ghost" wire:click="cancelDelete">{{ __('Cancel') }}</flux:button>
                <flux:button variant="danger" wire:click="deleteStaff">{{ __('Delete') }}</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
