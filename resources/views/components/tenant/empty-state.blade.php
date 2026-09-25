@props(['message' => '', 'actionLabel' => null, 'actionHref' => null])

<div class="rounded-lg border border-line bg-surface px-6 py-10 text-center">
    <p class="text-sm text-ink/70">{{ $message }}</p>
    @if ($actionLabel && $actionHref)
        <a href="{{ $actionHref }}" wire:navigate class="mt-4 inline-flex items-center rounded-md bg-brand px-4 py-2 text-sm font-medium text-white hover:bg-brand-deep">
            {{ $actionLabel }}
        </a>
    @endif
</div>
