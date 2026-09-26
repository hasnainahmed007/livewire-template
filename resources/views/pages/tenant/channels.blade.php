<div>
    <div class="mb-6">
        <h1 class="text-xl font-semibold">{{ __('Channels') }}</h1>
        <p class="mt-1 text-sm text-ink/60">{{ __('Connect the numbers and pages your customers already message.') }}</p>
    </div>

    @if ($notice)
        <p role="status" class="mb-4 rounded-md border border-line bg-surface px-4 py-2.5 text-sm">{{ $notice }}</p>
    @endif

    <section aria-labelledby="channels-list" class="rounded-lg border border-line bg-surface p-4">
        <h2 id="channels-list" class="text-sm font-semibold">{{ __('Connections') }}</h2>
        <ul class="mt-2 divide-y divide-line">
            @foreach ($channels as $channel)
                <li class="flex flex-wrap items-center justify-between gap-3 py-3 first:pt-1 last:pb-0">
                    <div>
                        <p class="text-sm font-medium">{{ $channel['label'] }}</p>
                        <p class="mt-0.5 font-mono text-xs text-ink/50">{{ $channel['detail'] }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <x-tenant.status-dot :state="$channel['connected'] ? 'success' : 'neutral'" :label="$channel['connected'] ? __('Connected') : __('Not connected')" />
                        @if ($channel['connected'])
                            <button type="button" wire:click="disconnect('{{ $channel['key'] }}')" class="rounded-md border border-line px-3 py-1.5 text-sm font-medium hover:bg-paper">{{ __('Disconnect') }}</button>
                        @else
                            <button type="button" wire:click="connect('{{ $channel['key'] }}')" class="rounded-md bg-brand px-3 py-1.5 text-sm font-medium text-white hover:bg-brand-deep">{{ __('Connect') }}</button>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    </section>

    <section aria-label="{{ __('About message costs') }}" class="mt-4 rounded-lg border border-line bg-surface p-4">
        <h2 class="text-sm font-semibold">{{ __('About message costs') }}</h2>
        <p class="mt-1 text-sm text-ink/60">{{ __('WhatsApp and Messenger are connected to your own Meta Business account. Meta bills you directly for those messages. Your subscription here covers the agent console only.') }}</p>
    </section>
</div>
