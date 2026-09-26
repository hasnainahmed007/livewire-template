{{-- Shared dark-mode toggle for the console topbars (tenant + superadmin).
     It MUST write through the Flux appearance store (window.Flux.appearance),
     not just the DOM class + storage: flux.js re-applies the store value on
     every `livewire:navigated` event, so a class-only toggle is wiped out on
     the next navigation. Vanilla JS on purpose: no Alpine dependency. --}}
<button
    type="button"
    data-appearance-toggle
    aria-pressed="false"
    title="{{ __('Toggle dark mode') }}"
    class="flex size-8 shrink-0 items-center justify-center rounded-md border border-line text-ink/70 hover:bg-ink/5 hover:text-ink"
>
    <span data-appearance-icon="moon" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 12 21.75a9.753 9.753 0 0 0 9.752-6.748Z" /></svg>
    </span>
    <span data-appearance-icon="sun" class="hidden" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" /></svg>
    </span>
    <span class="sr-only">{{ __('Toggle dark mode') }}</span>
</button>

<script>
(function () {
    // Flux boots window.Flux as its reactive appearance store. Present only
    // after flux.js loads; before that window.Flux is the head helper (if any).
    function store() {
        if (window.Flux && typeof window.Flux.appearance === 'string') return window.Flux;
        return null;
    }

    function isDark() { return document.documentElement.classList.contains('dark'); }

    function apply(dark) {
        var s = store();
        if (s) {
            // Reactive set: Flux's own effect applies the class, persists
            // storage, and re-applies on every livewire:navigated event.
            s.appearance = dark ? 'dark' : 'light';
            return;
        }
        if (window.Flux && typeof window.Flux.applyAppearance === 'function') {
            window.Flux.applyAppearance(dark ? 'dark' : 'light');
        } else {
            document.documentElement.classList.toggle('dark', dark);
            try { localStorage.setItem('flux.appearance', dark ? 'dark' : 'light'); } catch (e) {}
        }
    }

    // Paint from the intended value, not the DOM: the Flux effect that flips
    // the class can flush asynchronously, so reading the class here can lie.
    function paint(btn, dark) {
        btn.setAttribute('aria-pressed', dark ? 'true' : 'false');
        var moon = btn.querySelector('[data-appearance-icon="moon"]');
        var sun = btn.querySelector('[data-appearance-icon="sun"]');
        if (moon) moon.classList.toggle('hidden', dark);
        if (sun) sun.classList.toggle('hidden', !dark);
    }

    document.querySelectorAll('[data-appearance-toggle]').forEach(function (btn) {
        if (!btn.dataset.bound) {
            btn.dataset.bound = '1';
            btn.addEventListener('click', function () {
                var dark = !isDark();
                apply(dark);
                paint(btn, dark);
            });
        }
        paint(btn, isDark());
    });
})();
</script>
