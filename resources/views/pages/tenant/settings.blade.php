<div>
    <div class="mb-6">
        <h1 class="text-xl font-semibold">{{ __('Settings') }}</h1>
        <p class="mt-1 text-sm text-ink/60">{{ __('Business profile, who can sign in, and when you get notified.') }}</p>
    </div>

    @if ($notice)
        <p role="status" class="mb-4 rounded-md border border-line bg-surface px-4 py-2.5 text-sm">{{ $notice }}</p>
    @endif

    <div class="grid gap-4 lg:grid-cols-2">
        <section aria-labelledby="settings-profile" class="rounded-lg border border-line bg-surface p-4">
            <h2 id="settings-profile" class="text-sm font-semibold">{{ __('Business profile') }}</h2>
            <form wire:submit="saveProfile" class="mt-3 space-y-4">
                <div>
                    <label for="settings-business" class="mb-1 block text-sm font-medium">{{ __('Business name') }}</label>
                    <input id="settings-business" type="text" wire:model="businessName" class="w-full rounded-md border border-line bg-paper px-3 py-2 text-sm">
                    @error('businessName') <p role="alert" class="mt-1 text-sm text-error">{{ __('Add your business name.') }}</p> @enderror
                </div>
                <div>
                    <label for="settings-phone" class="mb-1 block text-sm font-medium">{{ __('Public phone number') }}</label>
                    <input id="settings-phone" type="text" wire:model="phone" class="w-full rounded-md border border-line bg-paper px-3 py-2 font-mono text-sm">
                    @error('phone') <p role="alert" class="mt-1 text-sm text-error">{{ __('Add a phone number customers can reach.') }}</p> @enderror
                </div>
                <div>
                    <label for="settings-timezone" class="mb-1 block text-sm font-medium">{{ __('Timezone') }}</label>
                    <select id="settings-timezone" wire:model="timezone" class="w-full rounded-md border border-line bg-paper px-3 py-2 text-sm">
                        <option>America/Chicago</option>
                        <option>America/New_York</option>
                        <option>America/Denver</option>
                        <option>America/Los_Angeles</option>
                    </select>
                </div>
                <button type="submit" class="rounded-md bg-brand px-4 py-2 text-sm font-medium text-white hover:bg-brand-deep">{{ __('Save settings') }}</button>
            </form>
        </section>

        <section aria-labelledby="settings-notify" class="rounded-lg border border-line bg-surface p-4">
            <h2 id="settings-notify" class="text-sm font-semibold">{{ __('Notifications') }}</h2>
            <form wire:submit="saveNotifications" class="mt-3 space-y-3">
                <label class="flex cursor-pointer items-start gap-2.5 text-sm">
                    <input type="checkbox" wire:model="notifyEscalations" class="mt-0.5 size-4 accent-[#2F5D50]">
                    <span><span class="font-medium">{{ __('Escalations') }}</span><span class="block text-ink/60">{{ __('Email me when a conversation needs a human.') }}</span></span>
                </label>
                <label class="flex cursor-pointer items-start gap-2.5 text-sm">
                    <input type="checkbox" wire:model="notifyFailures" class="mt-0.5 size-4 accent-[#2F5D50]">
                    <span><span class="font-medium">{{ __('Failures') }}</span><span class="block text-ink/60">{{ __('Email me when a reply fails to send.') }}</span></span>
                </label>
                <label class="flex cursor-pointer items-start gap-2.5 text-sm">
                    <input type="checkbox" wire:model="dailySummary" class="mt-0.5 size-4 accent-[#2F5D50]">
                    <span><span class="font-medium">{{ __('Daily summary') }}</span><span class="block text-ink/60">{{ __('One email each morning with volume and escalations.') }}</span></span>
                </label>
                <button type="submit" class="rounded-md border border-line px-4 py-2 text-sm font-medium hover:bg-paper">{{ __('Save notification preferences') }}</button>
            </form>
        </section>
    </div>

    <section aria-labelledby="settings-team" class="mt-4 rounded-lg border border-line bg-surface p-4">
        <h2 id="settings-team" class="text-sm font-semibold">{{ __('Team members') }}</h2>
        <ul class="mt-2 divide-y divide-line">
            @foreach ($members as $member)
                <li class="flex items-center justify-between gap-3 py-2.5 first:pt-0 last:pb-0">
                    <div>
                        <p class="text-sm font-medium">{{ $member['name'] }}</p>
                        <p class="font-mono text-xs text-ink/50">{{ $member['email'] }}</p>
                    </div>
                    <span class="text-sm text-ink/60">{{ $member['role'] }}</span>
                </li>
            @endforeach
        </ul>
        <form wire:submit="sendInvite" class="mt-4 flex flex-col gap-2 sm:flex-row">
            <label for="settings-invite" class="sr-only">{{ __('Invite by email') }}</label>
            <input id="settings-invite" type="email" wire:model="inviteEmail" placeholder="{{ __('teammate@business.com') }}" class="min-w-0 flex-1 rounded-md border border-line bg-paper px-3 py-2 text-sm placeholder:text-ink/40">
            <button type="submit" class="rounded-md bg-brand px-4 py-2 text-sm font-medium text-white hover:bg-brand-deep">{{ __('Send invite') }}</button>
        </form>
        @error('inviteEmail') <p role="alert" class="mt-1.5 text-sm text-error">{{ __('Enter a valid email address.') }}</p> @enderror
    </section>
</div>
