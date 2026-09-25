<div>
    <div class="mb-6">
        <h1 class="text-xl font-semibold">{{ __('Billing') }}</h1>
        <p class="mt-1 text-sm text-ink/60">{{ __('Your agent console subscription. Message charges from Meta are billed separately.') }}</p>
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        <section aria-labelledby="billing-plan" class="rounded-lg border border-line bg-surface p-4">
            <h2 id="billing-plan" class="text-sm font-semibold">{{ __('Current plan') }}</h2>
            <p class="mt-2 text-lg font-semibold">{{ __('Starter') }} <span class="font-mono text-sm font-normal text-ink/50">$49 / mo</span></p>
            <dl class="mt-3 space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-ink/60">{{ __('Agent replies included') }}</dt><dd class="font-mono">2,000 / mo</dd></div>
                <div class="flex justify-between"><dt class="text-ink/60">{{ __('Used this month') }}</dt><dd class="font-mono">1,204</dd></div>
                <div class="flex justify-between"><dt class="text-ink/60">{{ __('Renews') }}</dt><dd class="font-mono">Oct 1, 2026</dd></div>
            </dl>
        </section>

        <section aria-labelledby="billing-meta" class="rounded-lg border border-line bg-surface p-4">
            <h2 id="billing-meta" class="text-sm font-semibold">{{ __('Meta message charges') }}</h2>
            <p class="mt-2 text-sm text-ink/60">{{ __('WhatsApp and Messenger usage is billed directly by Meta to your own Business account. It never appears on your invoices below.') }}</p>
            <p class="mt-2 font-mono text-xs text-ink/50">{{ __('See exact message spend in your Meta Business billing settings.') }}</p>
        </section>
    </div>

    <section aria-labelledby="billing-invoices" class="mt-4 rounded-lg border border-line bg-surface p-4">
        <h2 id="billing-invoices" class="text-sm font-semibold">{{ __('Invoices') }}</h2>
        <div class="mt-2 overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-line text-ink/60">
                        <th scope="col" class="py-2 pr-4 font-medium">{{ __('Invoice') }}</th>
                        <th scope="col" class="py-2 pr-4 font-medium">{{ __('Date') }}</th>
                        <th scope="col" class="py-2 pr-4 font-medium">{{ __('Amount') }}</th>
                        <th scope="col" class="py-2 font-medium">{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td class="py-2.5 pr-4 font-mono text-xs">{{ $invoice['id'] }}</td>
                            <td class="py-2.5 pr-4">{{ $invoice['date'] }}</td>
                            <td class="py-2.5 pr-4 font-mono">{{ $invoice['amount'] }}</td>
                            <td class="py-2.5"><x-tenant.status-dot state="success" :label="$invoice['status']" /></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
