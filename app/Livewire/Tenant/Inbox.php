<?php

namespace App\Livewire\Tenant;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Unified inbox across SMS, WhatsApp, and Messenger.
 *
 * Static mock threads only. Wire to real conversation/message
 * models later; interaction methods below map 1:1 to real actions.
 */
#[Title('Inbox')]
#[Layout('layouts::tenant')]
class Inbox extends Component
{
    public string $search = '';

    public string $channelFilter = 'all';

    public string $handlingFilter = 'all';

    public bool $unreadOnly = false;

    public ?int $selectedThreadId = 1;

    public string $reply = '';

    public ?string $notice = null;

    public ?int $justRepliedThreadId = null;

    /** @var array<int, array{id: int, contact: string, phone: string, channel: string, handling: string, unread: bool, updated: string, preview: string}> */
    public array $threads = [
        ['id' => 1, 'contact' => 'Maria Santos', 'phone' => '+1 (555) 882-0147', 'channel' => 'WhatsApp', 'handling' => 'ai', 'unread' => true, 'updated' => '09:41', 'preview' => 'Can I move my appointment to Thursday?'],
        ['id' => 2, 'contact' => '+1 (555) 301-8842', 'phone' => '+1 (555) 301-8842', 'channel' => 'SMS', 'handling' => 'escalated', 'unread' => true, 'updated' => '09:28', 'preview' => 'I want to talk to a person please'],
        ['id' => 3, 'contact' => 'Daniel Reyes', 'phone' => 'm.me/daniel.reyes', 'channel' => 'Messenger', 'handling' => 'ai', 'unread' => false, 'updated' => '08:57', 'preview' => 'Thanks, that answers it'],
        ['id' => 4, 'contact' => 'Priya Nair', 'phone' => '+1 (555) 774-9021', 'channel' => 'SMS', 'handling' => 'ai', 'unread' => false, 'updated' => 'Yesterday', 'preview' => 'What are your opening hours?'],
    ];

    /** @var array<int, array{id: int, thread_id: int, from: string, body: string, time: string}> */
    public array $messages = [
        ['id' => 1, 'thread_id' => 1, 'from' => 'customer', 'body' => 'Hi, I have an appointment on Friday. Can I move it to Thursday?', 'time' => '09:36'],
        ['id' => 2, 'thread_id' => 1, 'from' => 'agent', 'body' => 'Of course. Thursday has 10:30 and 14:00 open. Which one works for you?', 'time' => '09:37'],
        ['id' => 3, 'thread_id' => 1, 'from' => 'customer', 'body' => 'Can I move my appointment to Thursday?', 'time' => '09:41'],
        ['id' => 4, 'thread_id' => 2, 'from' => 'customer', 'body' => 'I want to talk to a person please', 'time' => '09:28'],
        ['id' => 5, 'thread_id' => 2, 'from' => 'agent', 'body' => 'Understood. I have flagged this for the team and someone will reply here shortly.', 'time' => '09:28'],
    ];

    public function mount(): void
    {
        $search = (string) request()->query('search', '');

        if ($search !== '') {
            $this->search = $search;
        }
    }

    public function selectThread(int $threadId): void
    {
        $this->selectedThreadId = $threadId;
        $this->notice = null;
        $this->justRepliedThreadId = null;
        $this->reply = '';
    }

    public function markRead(int $threadId): void
    {
        foreach ($this->threads as &$thread) {
            if ($thread['id'] === $threadId) {
                $thread['unread'] = false;
            }
        }
        unset($thread);

        $this->notice = 'Conversation marked as read.';
    }

    public function sendReply(): void
    {
        $this->validate(['reply' => ['required', 'string', 'max:1000']]);

        $this->messages[] = [
            'id' => count($this->messages) + 1,
            'thread_id' => (int) $this->selectedThreadId,
            'from' => 'staff',
            'body' => $this->reply,
            'time' => 'Now',
        ];

        $this->justRepliedThreadId = $this->selectedThreadId;
        $this->reply = '';
        $this->notice = 'Reply sent.';
    }

    /** @return array<int, array{id: int, contact: string, phone: string, channel: string, handling: string, unread: bool, updated: string, preview: string}> */
    public function filteredThreads(): array
    {
        return array_values(array_filter($this->threads, function (array $thread): bool {
            if ($this->channelFilter !== 'all' && strtolower($thread['channel']) !== $this->channelFilter) {
                return false;
            }

            if ($this->handlingFilter !== 'all' && $thread['handling'] !== $this->handlingFilter) {
                return false;
            }

            if ($this->unreadOnly && ! $thread['unread']) {
                return false;
            }

            if ($this->search !== '' && stripos($thread['contact'].' '.$thread['preview'].' '.$thread['phone'], $this->search) === false) {
                return false;
            }

            return true;
        }));
    }

    public function selectedThread(): ?array
    {
        foreach ($this->threads as $thread) {
            if ($thread['id'] === $this->selectedThreadId) {
                return $thread;
            }
        }

        return null;
    }

    /** @return array<int, array{id: int, thread_id: int, from: string, body: string, time: string}> */
    public function threadMessages(): array
    {
        return array_values(array_filter(
            $this->messages,
            fn (array $message): bool => $message['thread_id'] === $this->selectedThreadId
        ));
    }

    public function render()
    {
        return view('livewire.tenant.inbox', [
            'visibleThreads' => $this->filteredThreads(),
            'activeThread' => $this->selectedThread(),
            'activeMessages' => $this->threadMessages(),
        ]);
    }
}
