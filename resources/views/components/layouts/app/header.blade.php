<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <header class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2" wire:navigate>
                        <x-app-logo />
                        <span class="sr-only">{{ config('app.name') }}</span>
                    </a>

                    <nav class="hidden md:flex items-center gap-1 text-sm">
                        <a href="{{ route('dashboard') }}" wire:navigate
                           class="rounded-md px-3 py-2 font-medium {{ request()->routeIs('dashboard') ? 'bg-white text-zinc-900 dark:bg-zinc-800 dark:text-white' : 'text-zinc-700 hover:text-zinc-900 dark:text-zinc-300 dark:hover:text-white' }}">
                            {{ __('Dashboard') }}
                        </a>
                        @if(auth()->check() && auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" wire:navigate
                               class="rounded-md px-3 py-2 font-medium {{ request()->routeIs('admin.*') ? 'bg-white text-zinc-900 dark:bg-zinc-800 dark:text-white' : 'text-zinc-700 hover:text-zinc-900 dark:text-zinc-300 dark:hover:text-white' }}">
                                {{ __('Admin Panel') }}
                            </a>
                        @endif
                    </nav>
                </div>

                <div class="flex items-center gap-3">
                    <x-ui.dropdown-menu>
                        <x-slot:trigger>
                            <div class="flex items-center gap-2">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                                <svg class="h-4 w-4 text-zinc-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </x-slot:trigger>

                        <div class="px-3 py-2">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                                <div class="min-w-0">
                                    <div class="truncate text-sm font-semibold">{{ auth()->user()->fullName() }}</div>
                                    <div class="truncate text-xs text-zinc-600 dark:text-zinc-300">{{ auth()->user()->email }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-zinc-200 dark:border-zinc-700"></div>

                        <div class="py-1 text-sm">
                            <a href="{{ route('settings.profile') }}" class="block px-4 py-2 hover:bg-zinc-50 dark:hover:bg-zinc-800" wire:navigate>{{ __('Settings') }}</a>
                        </div>

                        <div class="border-t border-zinc-200 dark:border-zinc-700"></div>

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="block w-full px-4 py-2 text-left text-sm hover:bg-zinc-50 dark:hover:bg-zinc-800">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </x-ui.dropdown-menu>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>
    </body>
</html>
