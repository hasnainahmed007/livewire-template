<?php

namespace App\Livewire\Tenant;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Tenant profile, team members, and notification preferences.
 * Mock data only; saves surface a confirmation notice.
 */
#[Title('Settings')]
#[Layout('layouts::tenant')]
class Settings extends Component
{
    public ?string $notice = null;

    public string $businessName = 'Demo business';

    public string $phone = '+1 (555) 014-2200';

    public string $timezone = 'America/Chicago';

    public string $inviteEmail = '';

    public bool $notifyEscalations = true;

    public bool $notifyFailures = true;

    public bool $dailySummary = false;

    /** @var array<int, array{id: int, name: string, email: string, role: string}> */
    public array $members = [
        ['id' => 1, 'name' => 'Ana Gomez', 'email' => 'ana@example.com', 'role' => 'Owner'],
        ['id' => 2, 'name' => 'Leo Park', 'email' => 'leo@example.com', 'role' => 'Staff'],
    ];

    public function saveProfile(): void
    {
        $this->validate([
            'businessName' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:40'],
            'timezone' => ['required', 'string', 'max:60'],
        ]);

        $this->notice = 'Settings saved.';
    }

    public function saveNotifications(): void
    {
        $this->notice = 'Notification preferences saved.';
    }

    public function sendInvite(): void
    {
        $this->validate(['inviteEmail' => ['required', 'email', 'max:160']]);

        $this->members[] = [
            'id' => count($this->members) + 1,
            'name' => 'Invited teammate',
            'email' => $this->inviteEmail,
            'role' => 'Staff',
        ];

        $this->inviteEmail = '';
        $this->notice = 'Invite sent.';
    }

    public function render()
    {
        return view('livewire.tenant.settings');
    }
}
