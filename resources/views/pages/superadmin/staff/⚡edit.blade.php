<?php

use App\Models\User;
use Flux\Flux;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Role;

new #[Title('Edit Staff'), Layout('layouts::superadmin')] class extends Component {
    use AuthorizesRequests;

    public User $staff;

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public string $role = '';

    public function mount(User $staff): void
    {
        $this->authorize('staff.edit');

        $staff->load('roles');

        $this->staff = $staff;
        $this->name = $staff->name;
        $this->email = $staff->email;
        $this->role = $staff->roles->first()?->name ?? '';
    }

    #[Computed]
    public function roles(): Collection
    {
        return Role::where('guard_name', 'web')
            ->whereIn('name', ['admin', 'manager'])
            ->orderBy('name')
            ->get();
    }

    public function save(): void
    {
        $this->authorize('staff.edit');

        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$this->staff->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,name',
        ]);

        $this->staff->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => filled($validated['password'] ?? null) ? Hash::make($validated['password']) : $this->staff->password,
        ]);

        $this->staff->syncRoles([$validated['role']]);

        Flux::toast(variant: 'success', text: __('Staff member updated successfully.'));

        $this->redirect(route('superadmin.staff.index', absolute: false), navigate: true);
    }
}; ?>

<div class="flex h-full w-full flex-1 flex-col gap-4">
    <flux:heading size="xl">{{ __('Edit staff: :name', ['name' => $staff->name]) }}</flux:heading>

    <flux:card class="max-w-2xl">
        <form wire:submit="save" class="flex flex-col gap-4">
            <flux:field>
                <flux:label>{{ __('Name') }}</flux:label>
                <flux:input wire:model="name" required />
                <flux:error name="name" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Email') }}</flux:label>
                <flux:input wire:model="email" type="email" required />
                <flux:error name="email" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Password (leave blank to keep)') }}</flux:label>
                <flux:input wire:model="password" type="password" viewable />
                <flux:error name="password" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Confirm password') }}</flux:label>
                <flux:input wire:model="password_confirmation" type="password" viewable />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Role') }}</flux:label>
                <flux:select wire:model="role">
                    @foreach ($this->roles as $role)
                        <flux:select.option value="{{ $role->name }}">{{ $role->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:error name="role" />
            </flux:field>

            <div class="flex gap-2">
                <flux:button variant="primary" type="submit">{{ __('Update') }}</flux:button>
                <flux:button variant="ghost" :href="route('superadmin.staff.index')" wire:navigate>{{ __('Cancel') }}</flux:button>
            </div>
        </form>
    </flux:card>
</div>