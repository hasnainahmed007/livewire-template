<div>
    <div class="mb-4">
        <h1 class="text-xl font-semibold">{{ __('Contacts') }}</h1>
        <p class="mt-1 text-sm text-ink/60">{{ __('Customers the agent has talked to, and how each prefers to be reached.') }}</p>
    </div>

    <div class="mb-4 flex flex-wrap gap-2">
        <label class="sr-only" for="contacts-search">{{ __('Search contacts') }}</label>
        <input id="contacts-search" type="search" wire:model.live="search" placeholder="{{ __('Search name or number') }}" autocomplete="off" class="w-full rounded-md border border-line bg-surface px-3 py-1.5 text-sm placeholder:text-ink/40 sm:w-64">
        <label class="sr-only" for="contacts-channel">{{ __('Filter by channel') }}</label>
        <select id="contacts-channel" wire:model.live="channelFilter" class="rounded-md border border-line bg-surface px-3 py-1.5 text-sm">
            <option value="all">{{ __('All channels') }}</option>
            <option value="sms">{{ __('SMS') }}</option>
            <option value="whatsapp">{{ __('WhatsApp') }}</option>
            <option value="messenger">{{ __('Messenger') }}</option>
        </select>
    </div>

    <div class="grid gap-4 lg:grid-cols-[380px_minmax(0,1fr)]">
        <section aria-label="{{ __('Contact list') }}" class="rounded-lg border border-line bg-surface">
            @if (count($visibleContacts) === 0)
                <div class="p-4">
                    <x-tenant.empty-state :message="__('No contacts match this search.')" />
                </div>
            @else
                <ul class="divide-y divide-line">
                    @foreach ($visibleContacts as $contact)
                        <li>
                            <button type="button" wire:click="selectContact({{ $contact['id'] }})" class="block w-full px-4 py-3 text-left hover:bg-paper {{ $contact['id'] === $selectedContactId ? 'bg-paper' : '' }}">
                                <span class="flex items-center justify-between gap-2">
                                    <span class="truncate text-sm font-medium">{{ $contact['name'] }}</span>
                                    <span class="shrink-0 font-mono text-xs text-ink/50">{{ $contact['conversations'] }} chats</span>
                                </span>
                                <span class="mt-0.5 block font-mono text-xs text-ink/50">{{ $contact['identifier'] }}</span>
                                <span class="mt-1 block text-xs text-ink/60">{{ __('Prefers :channel', ['channel' => $contact['preference']]) }} · {{ $contact['last_seen'] }}</span>
                            </button>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <section aria-label="{{ __('Contact history') }}" class="rounded-lg border border-line bg-surface p-4">
            @if (! $activeContact)
                <x-tenant.empty-state :message="__('Select a contact to see conversation history.')" />
            @else
                <h2 class="text-sm font-semibold">{{ $activeContact['name'] }}</h2>
                <p class="mt-0.5 font-mono text-xs text-ink/50">{{ $activeContact['identifier'] }} · {{ __('Prefers :channel', ['channel' => $activeContact['preference']]) }}</p>
                @if (count($activeHistory) === 0)
                    <div class="mt-4">
                        <x-tenant.empty-state :message="__('No conversation history for this contact yet.')" />
                    </div>
                @else
                    <ul class="mt-3 divide-y divide-line">
                        @foreach ($activeHistory as $row)
                            <li class="py-2.5 first:pt-0 last:pb-0">
                                <p class="text-sm">{{ $row['summary'] }}</p>
                                <p class="mt-0.5 font-mono text-xs text-ink/50">{{ $row['channel'] }} · {{ $row['when'] }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            @endif
        </section>
    </div>
</div>
