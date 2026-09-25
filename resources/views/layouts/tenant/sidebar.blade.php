<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="console-shell min-h-screen bg-paper font-sans text-ink antialiased">
        <a href="#tenant-main" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:bg-surface focus:px-4 focus:py-2 focus:text-ink">
            {{ __('Skip to content') }}
        </a>

        <div class="flex min-h-screen">
            {{-- Sidebar: 240px desktop, 64px icon rail on smaller screens. Square, hairline border. --}}
            @php
                $tenantNav = [
                    ['route' => 'tenant.dashboard', 'match' => 'tenant.dashboard', 'label' => __('Dashboard'), 'icon' => 'home'],
                    ['route' => 'tenant.inbox', 'match' => 'tenant.inbox*', 'label' => __('Inbox'), 'icon' => 'inbox'],
                    ['route' => 'tenant.agents', 'match' => 'tenant.agents*', 'label' => __('Agents'), 'icon' => 'agents'],
                    ['route' => 'tenant.flows', 'match' => 'tenant.flows*', 'label' => __('Flows'), 'icon' => 'flows'],
                    ['route' => 'tenant.contacts', 'match' => 'tenant.contacts*', 'label' => __('Contacts'), 'icon' => 'contacts'],
                    ['route' => 'tenant.channels', 'match' => 'tenant.channels*', 'label' => __('Channels'), 'icon' => 'channels'],
                    ['route' => 'tenant.billing', 'match' => 'tenant.billing*', 'label' => __('Billing'), 'icon' => 'billing'],
                    ['route' => 'tenant.settings', 'match' => 'tenant.settings*', 'label' => __('Settings'), 'icon' => 'settings'],
                ];
            @endphp

            <aside aria-label="{{ __('Agent console navigation') }}" class="flex w-16 shrink-0 flex-col border-e border-line bg-surface lg:w-60">
                <div class="flex h-14 items-center gap-2 border-b border-line px-3 lg:px-4">
                    <a href="{{ route('tenant.dashboard') }}" wire:navigate class="flex items-center gap-2 rounded-md">
                        <span class="flex size-8 shrink-0 items-center justify-center rounded-md bg-brand text-sm font-semibold text-white">A</span>
                        <span class="hidden text-sm font-semibold lg:inline">{{ __('Agent Console') }}</span>
                    </a>
                </div>

                <nav aria-label="{{ __('Primary') }}" class="flex-1 overflow-y-auto py-2">
                    <ul class="space-y-0.5 px-2">
                        @foreach ($tenantNav as $item)
                            @php $active = request()->routeIs($item['match']); @endphp
                            <li>
                                <a
                                    href="{{ route($item['route']) }}"
                                    wire:navigate
                                    @if ($active) aria-current="page" @endif
                                    title="{{ $item['label'] }}"
                                    class="flex items-center gap-3 rounded-md px-2.5 py-2 text-sm font-medium {{ $active ? 'bg-brand text-white' : 'text-ink/70 hover:bg-ink/5 hover:text-ink' }}"
                                >
                                    @switch($item['icon'])
                                        @case('home')
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 shrink-0" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75" /></svg>
                                            @break
                                        @case('inbox')
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 shrink-0" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162a2.25 2.25 0 0 0-.659-1.591l-2.965-2.965A2.25 2.25 0 0 0 16.531 8.75H9.469c-.598 0-1.172.237-1.595.659l-2.965 2.965a2.25 2.25 0 0 0-.659 1.591Zm13.916 3.015a3 3 0 1 0-5.832 0" /></svg>
                                            @break
                                        @case('agents')
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 shrink-0" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 0 0 2.25-2.25V6.75a2.25 2.25 0 0 0-2.25-2.25H6.75A2.25 2.25 0 0 0 4.5 6.75v10.5a2.25 2.25 0 0 0 2.25 2.25Zm.75-12h9v9h-9v-9Z" /></svg>
                                            @break
                                        @case('flows')
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 shrink-0" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a.75.75 0 0 1-1.06.664l-2.004-.849a.75.75 0 0 1-.436-.893V6.75A2.25 2.25 0 0 1 3.75 6Zm10.5 0a2.25 2.25 0 0 1 2.25-2.25H18.75A2.25 2.25 0 0 1 21 6v2.25a2.25 2.25 0 0 1-.659 1.591l-4.682 4.682a2.25 2.25 0 0 0-.659 1.591v3.138a.75.75 0 0 1-1.06.664l-2.004-.849a.75.75 0 0 1-.436-.893V6ZM3.75 20.25h16.5" /></svg>
                                            @break
                                        @case('contacts')
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 shrink-0" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
                                            @break
                                        @case('channels')
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 shrink-0" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" /></svg>
                                            @break
                                        @case('billing')
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 shrink-0" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" /></svg>
                                            @break
                                        @case('settings')
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 shrink-0" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 0 1 0 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                            @break
                                    @endswitch
                                    <span class="hidden lg:inline">{{ $item['label'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </nav>

                <div class="border-t border-line p-3">
                    <p class="hidden text-xs leading-5 text-ink/50 lg:block">{{ __('Operations console') }}</p>
                </div>
            </aside>

            <div class="flex min-w-0 flex-1 flex-col">
                {{-- Topbar: tenant name, search, profile. Square, hairline border. --}}
                <header class="sticky top-0 z-30 flex h-14 items-center gap-3 border-b border-line bg-surface px-4 lg:px-6">
                    <p class="min-w-0 truncate text-sm font-medium">
                        {{ __('Demo business') }}
                        <span class="ml-2 hidden font-mono text-xs font-normal text-ink/50 sm:inline">tenant_01</span>
                    </p>

                    <div class="mx-auto hidden w-full max-w-md md:block">
                        <form action="{{ route('tenant.inbox') }}" method="GET" role="search">
                            <label for="tenant-global-search" class="sr-only">{{ __('Search conversations and contacts') }}</label>
                            <input
                                id="tenant-global-search"
                                type="search"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="{{ __('Search conversations, contacts') }}"
                                autocomplete="off"
                                class="w-full rounded-md border border-line bg-paper px-3 py-1.5 text-sm text-ink placeholder:text-ink/40"
                            >
                        </form>
                    </div>

                    <div class="ml-auto flex items-center gap-3 md:ml-0">
                        <details class="relative">
                            <summary class="flex cursor-pointer list-none items-center gap-2 rounded-md [&::-webkit-details-marker]:hidden">
                                <span aria-hidden="true" class="flex size-8 items-center justify-center rounded-full bg-brand text-xs font-semibold text-white">{{ auth()->user()->initials() }}</span>
                                <span class="hidden text-left leading-tight sm:block">
                                    <span class="block max-w-32 truncate text-sm font-medium">{{ auth()->user()->name }}</span>
                                    <span class="block max-w-32 truncate text-xs text-ink/50">{{ auth()->user()->email }}</span>
                                </span>
                            </summary>
                            <div class="absolute end-0 top-full z-40 mt-2 w-56 rounded-lg border border-line bg-surface p-1 shadow-[0_8px_30px_rgb(0,0,0,0.08)]">
                                <div class="px-3 py-2">
                                    <p class="truncate text-sm font-medium">{{ auth()->user()->name }}</p>
                                    <p class="truncate font-mono text-xs text-ink/50">{{ auth()->user()->email }}</p>
                                </div>
                                <hr class="border-line">
                                <a href="{{ route('profile.edit') }}" wire:navigate class="block rounded-md px-3 py-2 text-sm hover:bg-ink/5">{{ __('Profile settings') }}</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full rounded-md px-3 py-2 text-left text-sm hover:bg-ink/5">{{ __('Log out') }}</button>
                                </form>
                            </div>
                        </details>
                    </div>
                </header>

                {{-- Main content: capped width, left-aligned working tool. --}}
                <main id="tenant-main" class="w-full flex-1">
                    <div class="mx-auto w-full max-w-[1200px] px-4 py-6 lg:px-8">
                        @if (session('status'))
                            <p role="status" class="mb-4 rounded-md border border-line bg-surface px-4 py-2.5 text-sm">{{ session('status') }}</p>
                        @endif

                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        @livewireScripts
    </body>
</html>
