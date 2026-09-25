<?php

namespace App\Livewire\Tenant;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Tenant operations dashboard.
 *
 * Placeholder mock data only — to be wired to real channel health,
 * conversation, and failure models later. No backend logic changed.
 */
#[Title('Dashboard')]
#[Layout('layouts::tenant')]
class Dashboard extends Component
{
    /** @var array<int, array{key: string, label: string, state: string, status: string, detail: string}> */
    public array $channelHealth = [
        ['key' => 'sms', 'label' => 'SMS', 'state' => 'success', 'status' => 'Responding', 'detail' => '+1 (555) 014-2200 · 42 replies today'],
        ['key' => 'whatsapp', 'label' => 'WhatsApp', 'state' => 'live', 'status' => 'Live', 'detail' => 'Connected to your Meta Business account · agent actively responding'],
        ['key' => 'messenger', 'label' => 'Messenger', 'state' => 'pending', 'status' => 'Connected', 'detail' => 'No failures in the last 24 hours'],
    ];

    /** @var array<int, array{id: int, contact: string, channel: string, reason: string, waiting: string}> */
    public array $takeover = [
        ['id' => 101, 'contact' => '+1 (555) 301-8842', 'channel' => 'SMS', 'reason' => 'Customer asked for a human', 'waiting' => '12 min'],
        ['id' => 102, 'contact' => 'Maria Santos', 'channel' => 'WhatsApp', 'reason' => 'Payment question the agent could not answer', 'waiting' => '26 min'],
    ];

    /** @var array<int, array{id: string, when: string, what: string, next: string}> */
    public array $failures = [
        ['id' => 'msg_8H21XA', 'when' => '09:42', 'what' => 'WhatsApp reply timed out after 30 seconds.', 'next' => 'Retry the reply from the Inbox.'],
        ['id' => 'msg_8H1QPM', 'when' => '08:15', 'what' => 'SMS delivery failed: carrier rejected the number.', 'next' => 'Check the number in Contacts, then resend.'],
    ];

    public function render()
    {
        return view('livewire.tenant.dashboard');
    }
}
