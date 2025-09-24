<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800" data-controller="theme">
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
                    <!-- Theme Toggle -->
                    <button
                        data-theme-target="toggle"
                        data-action="click->theme#toggle"
                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-700 hover:bg-zinc-200 dark:hover:bg-zinc-600 transition-colors"
                        aria-label="Toggle theme"
                    >
                        <svg class="w-4 h-4 text-zinc-700 dark:text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <!-- Default system icon -->
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </button>

                    <!-- User Dropdown -->
                    <div class="relative" data-controller="dropdown">
                        <button data-action="click->dropdown#toggle" class="flex items-center gap-2">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                {{ auth()->user()->initials() }}
                            </span>
                            <img src="/vendor/bladewind/icons/outline/chevron-down.svg" class="h-4 w-4 text-zinc-500 dark:text-zinc-400" alt="Dropdown">
                        </button>

                        <div data-dropdown-target="menu" data-action="click->dropdown#preventClose" class="absolute right-0 mt-2 w-56 origin-top-right rounded-lg bg-white dark:bg-zinc-800 py-1 shadow-lg ring-1 ring-black/5 dark:ring-white/10 focus:outline-none z-50 transform opacity-0 scale-95 transition-all duration-200 ease-out hidden">
                            <div class="px-4 py-3 border-b border-zinc-200 dark:border-zinc-700">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                    <div class="min-w-0">
                                        <div class="truncate text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ auth()->user()->fullName() }}</div>
                                        <div class="truncate text-xs text-zinc-600 dark:text-zinc-400">{{ auth()->user()->email }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="py-1">
                                <button
                                    data-theme-target="toggle"
                                    data-action="click->theme#toggle"
                                    class="flex w-full items-center px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700"
                                >
                                    <img src="/vendor/bladewind/icons/outline/sun.svg" class="w-4 h-4 mr-3 dark:filter dark:invert" alt="Theme">
                                    <span class="theme-text">System</span>
                                </button>

                                <div class="border-t border-zinc-200 dark:border-zinc-700 my-1"></div>

                                <a href="{{ route('settings.profile') }}" class="flex items-center px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700" wire:navigate>
                                    <img src="/vendor/bladewind/icons/outline/cog-6-tooth.svg" class="w-4 h-4 mr-3 dark:filter dark:invert" alt="Settings">
                                    {{ __('Settings') }}
                                </a>
                            </div>

                            <div class="border-t border-zinc-200 dark:border-zinc-700"></div>

                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="flex w-full items-center px-4 py-2 text-left text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700">
                                    <img src="/vendor/bladewind/icons/outline/arrow-right-on-rectangle.svg" class="w-4 h-4 mr-3 dark:filter dark:invert" alt="Logout">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>
    </body>
</html>
