<div>
    <div class="mb-6">
        <h1 class="text-xl font-semibold">{{ __('Dashboard') }}</h1>
        <p class="mt-1 text-sm text-ink/60">{{ __('Is your agent working, what is it saying, and what needs you right now.') }}</p>
    </div>

    <div class="grid gap-4 lg:grid-cols-3">
        <section aria-labelledby="tenant-health-heading" class="rounded-lg border border-line bg-surface p-4 lg:col-span-2">
            <h2 id="tenant-health-heading" class="text-sm font-semibold">{{ __('Agent health by channel') }}</h2>
            <ul class="mt-3 divide-y divide-line">
                @foreach ($channelHealth as $channel)
                    <li class="flex items-start justify-between gap-4 py-3 first:pt-0 last:pb-0">
                        <div>
                            <p class="text-sm font-medium">{{ $channel['label'] }}</p>
                            <p class="mt-0.5 font-mono text-xs text-ink/50">{{ $channel['detail'] }}</p>
                        </div>
                        <x-tenant.status-dot :state="$channel['state']" :label="$channel['status']" />
                    </li>
                @endforeach
            </ul>
        </section>

        <section aria-labelledby="tenant-volume-heading" class="rounded-lg border border-line bg-surface p-4">
            <h2 id="tenant-volume-heading" class="text-sm font-semibold">{{ __('Today') }}</h2>
            <dl class="mt-3 space-y-3">
                <div class="flex items-baseline justify-between">
                    <dt class="text-sm text-ink/60">{{ __('Conversations') }}</dt>
                    <dd class="font-mono text-lg font-medium">128</dd>
                </div>
                <div class="flex items-baseline justify-between">
                    <dt class="text-sm text-ink/60">{{ __('Handled by agent') }}</dt>
                    <dd class="font-mono text-lg font-medium">114</dd>
                </div>
                <div class="flex items-baseline justify-between">
                    <dt class="text-sm text-ink/60">{{ __('Escalated to you') }}</dt>
                    <dd class="font-mono text-lg font-medium">14</dd>
                </div>
            </dl>
            <a href="{{ route('tenant.inbox') }}" wire:navigate class="mt-4 inline-flex rounded-md border border-line px-3 py-1.5 text-sm font-medium hover:bg-paper">{{ __('Open inbox') }}</a>
        </section>
    </div>

    <div class="mt-4 grid gap-4 lg:grid-cols-2">
        <section aria-labelledby="tenant-takeover-heading" class="rounded-lg border border-line bg-surface p-4">
            <div class="flex items-center justify-between">
                <h2 id="tenant-takeover-heading" class="text-sm font-semibold">{{ __('Needs human takeover') }}</h2>
                <a href="{{ route('tenant.inbox') }}" wire:navigate class="text-sm font-medium text-brand hover:underline">{{ __('View all') }}</a>
            </div>
            @if (count($takeover) === 0)
                <x-tenant.empty-state :message="__('No conversations need you right now.')" />
            @else
                <ul class="mt-2 divide-y divide-line">
                    @foreach ($takeover as $item)
                        <li class="py-3 first:pt-1 last:pb-0">
                            <div class="flex items-center justify-between gap-3">
                                <p class="text-sm font-medium">{{ $item['contact'] }}</p>
                                <x-tenant.status-dot state="pending" :label="$item['channel']" />
                            </div>
                            <p class="mt-1 text-sm text-ink/60">{{ $item['reason'] }}</p>
                            <p class="mt-0.5 font-mono text-xs text-ink/50">{{ __('Waiting :time', ['time' => $item['waiting']]) }}</p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <section aria-labelledby="tenant-failures-heading" class="rounded-lg border border-line bg-surface p-4">
            <h2 id="tenant-failures-heading" class="text-sm font-semibold">{{ __('Recent failures') }}</h2>
            @if (count($failures) === 0)
                <x-tenant.empty-state :message="__('No failures in the last 24 hours.')" />
            @else
                <ul class="mt-2 divide-y divide-line">
                    @foreach ($failures as $failure)
                        <li class="py-3 first:pt-1 last:pb-0">
                            <div class="flex items-center gap-2">
                                <x-tenant.status-dot state="error" :label="__('Failed')" />
                                <span class="font-mono text-xs text-ink/50">{{ $failure['id'] }} · {{ $failure['when'] }}</span>
                            </div>
                            <p class="mt-1 text-sm">{{ $failure['what'] }}</p>
                            <p class="mt-0.5 text-sm text-ink/60">{{ $failure['next'] }}</p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    </div>
</div>
