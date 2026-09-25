<?php

namespace App\Livewire\Tenant;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Customer list with per-contact history and channel preference.
 * Mock data only.
 */
#[Title('Contacts')]
#[Layout('layouts::tenant')]
class Contacts extends Component
{
    public string $search = '';

    public string $channelFilter = 'all';

    public ?int $selectedContactId = 1;

    /** @var array<int, array{id: int, name: string, identifier: string, channel: string, preference: string, last_seen: string, conversations: int}> */
    public array $contacts = [
        ['id' => 1, 'name' => 'Maria Santos', 'identifier' => '+1 (555) 882-0147', 'channel' => 'WhatsApp', 'preference' => 'WhatsApp', 'last_seen' => 'Today 09:41', 'conversations' => 6],
        ['id' => 2, 'name' => 'Unknown number', 'identifier' => '+1 (555) 301-8842', 'channel' => 'SMS', 'preference' => 'SMS', 'last_seen' => 'Today 09:28', 'conversations' => 2],
        ['id' => 3, 'name' => 'Daniel Reyes', 'identifier' => 'm.me/daniel.reyes', 'channel' => 'Messenger', 'preference' => 'Messenger', 'last_seen' => 'Today 08:57', 'conversations' => 4],
        ['id' => 4, 'name' => 'Priya Nair', 'identifier' => '+1 (555) 774-9021', 'channel' => 'SMS', 'preference' => 'SMS', 'last_seen' => 'Yesterday', 'conversations' => 1],
    ];

    /** @var array<int, array{contact_id: int, when: string, summary: string, channel: string}> */
    public array $history = [
        ['contact_id' => 1, 'when' => 'Today 09:41', 'summary' => 'Asked to move a Friday appointment to Thursday', 'channel' => 'WhatsApp'],
        ['contact_id' => 1, 'when' => 'Mon 14:02', 'summary' => 'Confirmed teeth cleaning reminder', 'channel' => 'WhatsApp'],
        ['contact_id' => 2, 'when' => 'Today 09:28', 'summary' => 'Asked for a human; escalated to staff', 'channel' => 'SMS'],
        ['contact_id' => 3, 'when' => 'Today 08:57', 'summary' => 'FAQ about pricing answered by agent', 'channel' => 'Messenger'],
    ];

    public function selectContact(int $contactId): void
    {
        $this->selectedContactId = $contactId;
    }

    /** @return array<int, array{id: int, name: string, identifier: string, channel: string, preference: string, last_seen: string, conversations: int}> */
    public function filteredContacts(): array
    {
        return array_values(array_filter($this->contacts, function (array $contact): bool {
            if ($this->channelFilter !== 'all' && strtolower($contact['channel']) !== $this->channelFilter) {
                return false;
            }

            if ($this->search !== '' && stripos($contact['name'].' '.$contact['identifier'], $this->search) === false) {
                return false;
            }

            return true;
        }));
    }

    public function render()
    {
        $visible = $this->filteredContacts();
        $active = null;

        foreach ($this->contacts as $contact) {
            if ($contact['id'] === $this->selectedContactId) {
                $active = $contact;
            }
        }

        $activeHistory = array_values(array_filter(
            $this->history,
            fn (array $row): bool => $row['contact_id'] === $this->selectedContactId
        ));

        return view('livewire.tenant.contacts', [
            'visibleContacts' => $visible,
            'activeContact' => $active,
            'activeHistory' => $activeHistory,
        ]);
    }
}
