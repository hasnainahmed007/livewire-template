<div>
    <div class="mb-6">
        <h1 class="text-xl font-semibold">{{ __('Flows') }}</h1>
        <p class="mt-1 text-sm text-ink/60">{{ __('Tell the agent when to reply, what to say, and when to bring in a human.') }}</p>
    </div>

    @if ($notice)
        <p role="status" class="mb-4 rounded-md border border-line bg-surface px-4 py-2.5 text-sm">{{ $notice }}</p>
    @endif

    <div class="grid gap-4 lg:grid-cols-2">
        <section aria-labelledby="flows-existing" class="rounded-lg border border-line bg-surface p-4">
            <h2 id="flows-existing" class="text-sm font-semibold">{{ __('Active flows') }}</h2>
            <ul class="mt-3 divide-y divide-line">
                @forelse ($flows as $flow)
                    <li class="py-3 first:pt-0 last:pb-0">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-medium">{{ $flow['name'] }}</p>
                                <dl class="mt-1.5 space-y-1 text-sm text-ink/60">
                                    <div class="flex gap-2"><dt class="w-20 shrink-0 font-medium text-ink/80">{{ __('Trigger') }}</dt><dd>{{ $flow['trigger'] }}</dd></div>
                                    <div class="flex gap-2"><dt class="w-20 shrink-0 font-medium text-ink/80">{{ __('Response') }}</dt><dd>{{ $flow['response'] }}</dd></div>
                                    <div class="flex gap-2"><dt class="w-20 shrink-0 font-medium text-ink/80">{{ __('Escalation') }}</dt><dd>{{ $flow['escalation'] }}</dd></div>
                                </dl>
                            </div>
                            <div class="flex shrink-0 flex-col items-end gap-2">
                                <x-tenant.status-dot :state="$flow['active'] ? 'success' : 'neutral'" :label="$flow['active'] ? __('On') : __('Off')" />
                                <button type="button" wire:click="toggleFlow({{ $flow['id'] }})" class="rounded-md border border-line px-2.5 py-1 text-xs font-medium hover:bg-paper">
                                    {{ $flow['active'] ? __('Turn off') : __('Turn on') }}
                                </button>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="py-2 text-sm text-ink/60">{{ __('No flows yet. Create the first one on this page.') }}</li>
                @endforelse
            </ul>
        </section>

        <section aria-labelledby="flows-new" class="rounded-lg border border-line bg-surface p-4">
            <h2 id="flows-new" class="text-sm font-semibold">{{ __('New flow') }}</h2>
            <form wire:submit="saveFlow" class="mt-3 space-y-4">
                <div>
                    <label for="flow-name" class="mb-1 block text-sm font-medium">{{ __('Flow name') }}</label>
                    <input id="flow-name" type="text" wire:model="name" placeholder="{{ __('Appointment booking') }}" class="w-full rounded-md border border-line bg-paper px-3 py-2 text-sm placeholder:text-ink/40">
                    @error('name') <p role="alert" class="mt-1 text-sm text-error">{{ __('Give the flow a short name.') }}</p> @enderror
                </div>

                <div class="grid gap-3 sm:grid-cols-2">
                    <div>
                        <label for="flow-trigger-type" class="mb-1 block text-sm font-medium">{{ __('Trigger type') }}</label>
                        <select id="flow-trigger-type" wire:model="triggerType" class="w-full rounded-md border border-line bg-paper px-3 py-2 text-sm">
                            <option value="contains">{{ __('Message contains') }}</option>
                            <option value="exact">{{ __('Message equals') }}</option>
                            <option value="always">{{ __('Every message') }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="flow-trigger-value" class="mb-1 block text-sm font-medium">{{ __('Trigger words') }}</label>
                        <input id="flow-trigger-value" type="text" wire:model="triggerValue" placeholder="{{ __('book, appointment') }}" class="w-full rounded-md border border-line bg-paper px-3 py-2 text-sm placeholder:text-ink/40">
                    </div>
                </div>
                @error('triggerValue') <p role="alert" class="-mt-2 text-sm text-error">{{ __('Add the words that start this flow.') }}</p> @enderror

                <div>
                    <label for="flow-response" class="mb-1 block text-sm font-medium">{{ __('Agent response') }}</label>
                    <textarea id="flow-response" wire:model="response" rows="3" placeholder="{{ __('What should the agent say?') }}" class="w-full rounded-md border border-line bg-paper px-3 py-2 text-sm placeholder:text-ink/40"></textarea>
                    @error('response') <p role="alert" class="mt-1 text-sm text-error">{{ __('Write the reply the agent should send.') }}</p> @enderror
                </div>

                <div>
                    <label for="flow-escalation" class="mb-1 block text-sm font-medium">{{ __('Escalation') }}</label>
                    <select id="flow-escalation" wire:model="escalation" class="w-full rounded-md border border-line bg-paper px-3 py-2 text-sm">
                        <option>{{ __('Escalate when the customer asks for a human') }}</option>
                        <option>{{ __('Escalate after 2 unanswered follow-ups') }}</option>
                        <option>{{ __('Never escalate') }}</option>
                    </select>
                </div>

                <button type="submit" class="rounded-md bg-brand px-4 py-2 text-sm font-medium text-white hover:bg-brand-deep">{{ __('Save flow') }}</button>
            </form>
        </section>
    </div>
</div>
