<div>
    <div class="mb-6 flex flex-wrap items-start justify-between gap-3">
        <div>
            <h1 class="text-xl font-semibold">{{ __('Agents') }}</h1>
            <p class="mt-1 text-sm text-ink/60">{{ __('Each agent answers on its channels. Pause any agent immediately if something looks wrong.') }}</p>
        </div>
    </div>

    @if ($notice)
        <p role="status" class="mb-4 rounded-md border border-line bg-surface px-4 py-2.5 text-sm">{{ $notice }}</p>
    @endif

    @if (count($agents) === 0)
        <x-tenant.empty-state :message="__('No agents yet. Create your first agent to start answering customers.')" />
    @else
        <ul class="space-y-4">
            @foreach ($agents as $agent)
                <li class="rounded-lg border border-line bg-surface p-4">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <h2 class="text-sm font-semibold">{{ $agent['name'] }}</h2>
                            <p class="mt-0.5 text-sm text-ink/60">{{ __('Flow: :flow', ['flow' => $agent['flow']]) }} · {{ __('Tone: :tone', ['tone' => $agent['tone']]) }}</p>
                            <p class="mt-1 font-mono text-xs text-ink/50">{{ implode(' · ', $agent['channels']) }} · {{ __(':count handled today', ['count' => $agent['handled_today']]) }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-tenant.status-dot :state="$agent['paused'] ? 'pending' : 'live'" :label="$agent['paused'] ? __('Paused') : __('Responding')" />
                            <button type="button" wire:click="togglePause({{ $agent['id'] }})" class="rounded-md px-4 py-2 text-sm font-medium {{ $agent['paused'] ? 'bg-brand text-white hover:bg-brand-deep' : 'border border-line hover:bg-paper' }}">
                                {{ $agent['paused'] ? __('Resume agent') : __('Pause agent') }}
                            </button>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
