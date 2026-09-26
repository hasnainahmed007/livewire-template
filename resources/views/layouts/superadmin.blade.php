<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="console-shell min-h-screen bg-paper font-sans text-ink antialiased">
        <a href="#superadmin-main" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:bg-surface focus:px-4 focus:py-2 focus:text-ink">
            {{ __('Skip to content') }}
        </a>

        <div class="flex min-h-screen">
            {{-- Sidebar: 240px desktop, 64px icon rail on smaller screens. Square, hairline border. --}}
            <aside aria-label="{{ __('Platform navigation') }}" class="flex w-16 shrink-0 flex-col border-e border-line bg-surface lg:w-60">
                <div class="flex h-14 items-center gap-2 border-b border-line px-3 lg:px-4">
                    <a href="{{ route('superadmin.dashboard') }}" wire:navigate class="flex items-center gap-2 rounded-md">
                        <span class="flex size-8 shrink-0 items-center justify-center rounded-md bg-brand text-sm font-semibold text-white">S</span>
                        <span class="hidden text-sm font-semibold lg:inline">{{ __('Platform admin') }}</span>
                    </a>
                </div>

                <nav aria-label="{{ __('Primary') }}" class="flex-1 overflow-y-auto py-2">
                    <p class="hidden px-4 pb-1 pt-2 text-xs font-medium text-ink/50 lg:block">{{ __('Platform') }}</p>
                    <ul class="space-y-0.5 px-2">
                        <li>
                            <a
                                href="{{ route('superadmin.dashboard') }}"
                                wire:navigate
                                @if (request()->routeIs('superadmin.dashboard')) aria-current="page" @endif
                                title="{{ __('Dashboard') }}"
                                class="flex items-center gap-3 rounded-md px-2.5 py-2 text-sm font-medium {{ request()->routeIs('superadmin.dashboard') ? 'bg-brand text-white' : 'text-ink/70 hover:bg-ink/5 hover:text-ink' }}"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 shrink-0" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75" /></svg>
                                <span class="hidden lg:inline">{{ __('Dashboard') }}</span>
                            </a>
                        </li>
                    </ul>

                    <p class="hidden px-4 pb-1 pt-4 text-xs font-medium text-ink/50 lg:block">{{ __('Management') }}</p>
                    <ul class="space-y-0.5 px-2">
                        @can('staff.read')
                            <li>
                                <a
                                    href="{{ route('superadmin.staff.index') }}"
                                    wire:navigate
                                    @if (request()->routeIs('superadmin.staff.*')) aria-current="page" @endif
                                    title="{{ __('Staff') }}"
                                    class="flex items-center gap-3 rounded-md px-2.5 py-2 text-sm font-medium {{ request()->routeIs('superadmin.staff.*') ? 'bg-brand text-white' : 'text-ink/70 hover:bg-ink/5 hover:text-ink' }}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 shrink-0" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
                                    <span class="hidden lg:inline">{{ __('Staff') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('roles.read')
                            <li>
                                <a
                                    href="{{ route('superadmin.roles.index') }}"
                                    wire:navigate
                                    @if (request()->routeIs('superadmin.roles.*')) aria-current="page" @endif
                                    title="{{ __('Roles') }}"
                                    class="flex items-center gap-3 rounded-md px-2.5 py-2 text-sm font-medium {{ request()->routeIs('superadmin.roles.*') ? 'bg-brand text-white' : 'text-ink/70 hover:bg-ink/5 hover:text-ink' }}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 shrink-0" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" /></svg>
                                    <span class="hidden lg:inline">{{ __('Roles') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('permissions.read')
                            <li>
                                <a
                                    href="{{ route('superadmin.permissions.index') }}"
                                    wire:navigate
                                    @if (request()->routeIs('superadmin.permissions.*')) aria-current="page" @endif
                                    title="{{ __('Permissions') }}"
                                    class="flex items-center gap-3 rounded-md px-2.5 py-2 text-sm font-medium {{ request()->routeIs('superadmin.permissions.*') ? 'bg-brand text-white' : 'text-ink/70 hover:bg-ink/5 hover:text-ink' }}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 shrink-0" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" /></svg>
                                    <span class="hidden lg:inline">{{ __('Permissions') }}</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </nav>
            </aside>

            <div class="flex min-w-0 flex-1 flex-col">
                {{-- Topbar: platform name and profile. Square, hairline border. --}}
                <header class="sticky top-0 z-30 flex h-14 items-center gap-3 border-b border-line bg-surface px-4 lg:px-6">
                    <div class="ml-auto flex items-center gap-3">
                        @include('partials.console-appearance-toggle')

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
                                    <button type="submit" class="block w-full rounded-md px-3 py-2 text-left text-sm hover:bg-ink/5" data-test="logout-button">{{ __('Log out') }}</button>
                                </form>
                            </div>
                        </details>
                    </div>
                </header>

                {{-- Main content: capped width, left-aligned working tool. --}}
                <main id="superadmin-main" class="w-full flex-1">
                    <div class="mx-auto w-full max-w-[1200px] px-4 py-6 lg:px-8">
                        @if (session('status'))
                            <p role="status" class="mb-4 rounded-md border border-line bg-surface px-4 py-2.5 text-sm">{{ session('status') }}</p>
                        @endif

                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
