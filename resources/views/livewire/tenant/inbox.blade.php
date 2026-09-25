<div>
    <div class="mb-4">
        <h1 class="text-xl font-semibold">{{ __('Inbox') }}</h1>
        <p class="mt-1 text-sm text-ink/60">{{ __('Every SMS, WhatsApp, and Messenger conversation in one place.') }}</p>
    </div>

    @if ($notice)
        <p role="status" class="mb-4 rounded-md border border-line bg-surface px-4 py-2.5 text-sm">{{ $notice }}</p>
    @endif

    <div class="mb-4 flex flex-wrap items-center gap-2">
        <label class="sr-only" for="inbox-search">{{ __('Search conversations') }}</label>
        <input id="inbox-search" type="search" wire:model.live="search" placeholder="{{ __('Search name, number, or text') }}" autocomplete="off" class="w-full rounded-md border border-line bg-surface px-3 py-1.5 text-sm placeholder:text-ink/40 sm:w-64">

        <label class="sr-only" for="inbox-channel">{{ __('Filter by channel') }}</label>
        <select id="inbox-channel" wire:model.live="channelFilter" class="rounded-md border border-line bg-surface px-3 py-1.5 text-sm">
            <option value="all">{{ __('All channels') }}</option>
            <option value="sms">{{ __('SMS') }}</option>
            <option value="whatsapp">{{ __('WhatsApp') }}</option>
            <option value="messenger">{{ __('Messenger') }}</option>
        </select>

        <label class="sr-only" for="inbox-handling">{{ __('Filter by handling') }}</label>
        <select id="inbox-handling" wire:model.live="handlingFilter" class="rounded-md border border-line bg-surface px-3 py-1.5 text-sm">
            <option value="all">{{ __('AI and escalated') }}</option>
            <option value="ai">{{ __('AI handled') }}</option>
            <option value="escalated">{{ __('Escalated') }}</option>
        </select>

        <label class="inline-flex cursor-pointer items-center gap-2 rounded-md border border-line bg-surface px-3 py-1.5 text-sm">
            <input type="checkbox" wire:model.live="unreadOnly" class="size-4 accent-[#2F5D50]">
            {{ __('Unread only') }}
        </label>
    </div>

    <div class="grid gap-4 lg:grid-cols-[340px_minmax(0,1fr)]">
        <section aria-label="{{ __('Conversations') }}" class="rounded-lg border border-line bg-surface">
            @if (count($visibleThreads) === 0)
                <div class="p-4">
                    <x-tenant.empty-state :message="__('No conversations yet. Connect a channel to start receiving messages.')" :actionLabel="__('Connect a channel')" :actionHref="route('tenant.channels')" />
                </div>
            @else
                <ul class="divide-y divide-line">
                    @foreach ($visibleThreads as $thread)
                        <li>
                            <button type="button" wire:click="selectThread({{ $thread['id'] }})" aria-current="{{ $thread['id'] === $selectedThreadId ? 'true' : 'false' }}" class="block w-full px-4 py-3 text-left hover:bg-paper {{ $thread['id'] === $selectedThreadId ? 'bg-paper' : '' }}">
                                <span class="flex items-center justify-between gap-2">
                                    <span class="truncate text-sm font-medium">
                                        @if ($thread['unread'])
                                            <span aria-hidden="true" class="mr-1.5 inline-block size-2 rounded-full bg-live"></span><span class="sr-only">{{ __('Unread:') }}</span>{{ $thread['contact'] }}
                                        @else
                                            {{ $thread['contact'] }}
                                        @endif
                                    </span>
                                    <span class="shrink-0 font-mono text-xs text-ink/50">{{ $thread['updated'] }}</span>
                                </span>
                                <span class="mt-1 flex items-center justify-between gap-2">
                                    <span class="truncate text-sm text-ink/60">{{ $thread['preview'] }}</span>
                                </span>
                                <span class="mt-1.5 flex items-center gap-3 text-xs text-ink/60">
                                    <x-tenant.status-dot state="{{ $thread['handling'] === 'escalated' ? 'pending' : 'success' }}" :label="$thread['handling'] === 'escalated' ? __('Escalated') : __('AI handled')" />
                                    <span>{{ $thread['channel'] }}</span>
                                </span>
                            </button>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <section aria-label="{{ __('Conversation') }}" class="flex min-h-[420px] flex-col rounded-lg border border-line bg-surface">
            @if (! $activeThread)
                <div class="p-6">
                    <x-tenant.empty-state :message="__('Select a conversation to read and reply.')" />
                </div>
            @else
                <div class="border-b border-line px-4 py-3">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <div>
                            <h2 class="text-sm font-semibold">{{ $activeThread['contact'] }}</h2>
                            <p class="font-mono text-xs text-ink/50">{{ $activeThread['phone'] }} · {{ $activeThread['channel'] }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-tenant.status-dot state="{{ $activeThread['handling'] === 'escalated' ? 'pending' : 'success' }}" :label="$activeThread['handling'] === 'escalated' ? __('Escalated to human') : __('Handled by agent')" />
                            @if ($activeThread['unread'])
                                <button type="button" wire:click="markRead({{ $activeThread['id'] }})" class="rounded-md border border-line px-2.5 py-1 text-xs font-medium hover:bg-paper">{{ __('Mark as read') }}</button>
                            @endif
                        </div>
                    </div>
                </div>

                <ul class="flex-1 space-y-3 overflow-y-auto px-4 py-4" aria-live="polite">
                    @foreach ($activeMessages as $message)
                        <li class="flex {{ $message['from'] === 'customer' ? 'justify-start' : 'justify-end' }}">
                            <div class="{{ $message['from'] === 'customer' ? 'bg-paper text-ink' : 'bg-brand text-white' }} {{ $justRepliedThreadId === $activeThread['id'] && $message['from'] === 'staff' && $loop->last ? 'tenant-inbox-new' : '' }} max-w-[80%] rounded-lg border border-line px-3 py-2">
                                <p class="text-sm">{{ $message['body'] }}</p>
                                <p class="mt-1 font-mono text-[11px] {{ $message['from'] === 'customer' ? 'text-ink/50' : 'text-white/70' }}">
                                    {{ $message['from'] === 'customer' ? __('Customer') : ($message['from'] === 'agent' ? __('Agent') : __('You')) }} · {{ $message['time'] }}
                                </p>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <form wire:submit="sendReply" class="border-t border-line px-4 py-3">
                    <label for="inbox-reply" class="sr-only">{{ __('Reply') }}</label>
                    <div class="flex gap-2">
                        <input id="inbox-reply" type="text" wire:model="reply" placeholder="{{ __('Write a reply as the business') }}" autocomplete="off" class="min-w-0 flex-1 rounded-md border border-line bg-paper px-3 py-2 text-sm placeholder:text-ink/40">
                        <button type="submit" class="shrink-0 rounded-md bg-brand px-4 py-2 text-sm font-medium text-white hover:bg-brand-deep">{{ __('Send reply') }}</button>
                    </div>
                    @error('reply') <p role="alert" class="mt-1.5 text-sm text-error">{{ __('Write a message before sending.') }}</p> @enderror
                </form>
            @endif
        </section>
    </div>
</div>
