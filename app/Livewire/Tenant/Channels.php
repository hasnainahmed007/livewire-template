<?php

namespace App\Livewire\Tenant;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Channel connection status. Tenants pay Meta directly —
 * this screen never implies message costs are billed by us.
 * Mock data only.
 */
#[Title('Channels')]
#[Layout('layouts::tenant')]
class Channels extends Component
{
    public ?string $notice = null;

    /** @var array<int, array{key: string, label: string, connected: bool, detail: string}> */
    public array $channels = [
        ['key' => 'sms', 'label' => 'SMS number', 'connected' => true, 'detail' => '+1 (555) 014-2200 · delivery working'],
        ['key' => 'whatsapp', 'label' => 'WhatsApp Business', 'connected' => true, 'detail' => 'Connected to your own Meta Business account'],
        ['key' => 'messenger', 'label' => 'Messenger', 'connected' => false, 'detail' => 'Not connected yet'],
    ];

    public function connect(string $key): void
    {
        foreach ($this->channels as &$channel) {
            if ($channel['key'] === $key) {
                $channel['connected'] = true;
                $this->notice = $channel['label'].' connected.';
            }
        }
        unset($channel);
    }

    public function disconnect(string $key): void
    {
        foreach ($this->channels as &$channel) {
            if ($channel['key'] === $key) {
                $channel['connected'] = false;
                $this->notice = $channel['label'].' disconnected.';
            }
        }
        unset($channel);
    }

    public function render()
    {
        return view('pages.tenant.channels');
    }
}
