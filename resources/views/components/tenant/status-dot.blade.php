@props(['state' => 'neutral', 'label' => ''])

@php
    $dots = [
        'success' => 'bg-success',
        'error' => 'bg-error',
        'pending' => 'bg-pending',
        'live' => 'bg-live',
        'neutral' => 'bg-ink/30',
    ];
    $dot = $dots[$state] ?? $dots['neutral'];
@endphp

<span class="inline-flex items-center gap-1.5 text-sm text-ink/80">
    <span aria-hidden="true" class="size-2 shrink-0 rounded-full {{ $dot }}"></span>
    <span>{{ $label }}</span>
</span>
