<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ open: false }" class="h-full">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
        <div class="flex h-screen overflow-hidden">
            <!-- Mobile sidebar overlay -->
            <div x-show="open" x-transition.opacity class="fixed inset-0 z-40 bg-black/40 lg:hidden" @click="open=false"></div>

            <!-- Sidebar (mobile drawer) -->
            <aside x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="fixed inset-y-0 left-0 z-50 w-72 overflow-y-auto bg-white dark:bg-zinc-800 border-r border-zinc-200 dark:border-zinc-700 p-0 lg:hidden">
                <!-- Sidebar Header -->
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center gap-3">
                        <x-app-logo />
                        <div>
                            <div class="font-semibold text-zinc-900 dark:text-zinc-100">Spotlight</div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-amber-100 text-amber-800 align-middle">Admin Panel</span>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="p-6 space-y-1">
                    <a href="{{ route('admin.dashboard') }}" wire:navigate class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-zinc-100 text-zinc-900 dark:bg-zinc-700 dark:text-white' : 'text-zinc-700 hover:bg-zinc-50 dark:text-zinc-300 dark:hover:bg-zinc-700/60' }}">{{ __('Dashboard') }}</a>

                    <a href="{{ route('admin.users.index') }}" wire:navigate class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'bg-zinc-100 text-zinc-900 dark:bg-zinc-700 dark:text-white' : 'text-zinc-700 hover:bg-zinc-50 dark:text-zinc-300 dark:hover:bg-zinc-700/60' }}">{{ __('User Management') }}</a>

                    <a href="{{ route('admin.notifications.index') }}" wire:navigate class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.notifications.*') ? 'bg-zinc-100 text-zinc-900 dark:bg-zinc-700 dark:text-white' : 'text-zinc-700 hover:bg-zinc-50 dark:text-zinc-300 dark:hover:bg-zinc-700/60' }}">{{ __('Notifications') }}</a>

                    <a href="{{ route('admin.communications.index') }}" wire:navigate class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.communications.*') ? 'bg-zinc-100 text-zinc-900 dark:bg-zinc-700 dark:text-white' : 'text-zinc-700 hover:bg-zinc-50 dark:text-zinc-300 dark:hover:bg-zinc-700/60' }}">{{ __('Communications') }}</a>
                </nav>
            </aside>

            <!-- Sidebar (desktop) -->
            <aside class="hidden lg:flex lg:w-72 lg:flex-col lg:border-r lg:border-zinc-200 lg:dark:border-zinc-700 lg:bg-white lg:dark:bg-zinc-800">
                <!-- Sidebar Header -->
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center gap-3">
                        <x-app-logo />
                        <div>
                            <div class="font-semibold text-zinc-900 dark:text-zinc-100">Spotlight</div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-amber-100 text-amber-800 align-middle">Admin Panel</span>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 p-6 space-y-1">
                    <a href="{{ route('admin.dashboard') }}" wire:navigate class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-zinc-100 text-zinc-900 dark:bg-zinc-700 dark:text-white' : 'text-zinc-700 hover:bg-zinc-50 dark:text-zinc-300 dark:hover:bg-zinc-700/60' }}">{{ __('Dashboard') }}</a>

                    <a href="{{ route('admin.users.index') }}" wire:navigate class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'bg-zinc-100 text-zinc-900 dark:bg-zinc-700 dark:text-white' : 'text-zinc-700 hover:bg-zinc-50 dark:text-zinc-300 dark:hover:bg-zinc-700/60' }}">{{ __('User Management') }}</a>

                    <a href="{{ route('admin.notifications.index') }}" wire:navigate class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.notifications.*') ? 'bg-zinc-100 text-zinc-900 dark:bg-zinc-700 dark:text-white' : 'text-zinc-700 hover:bg-zinc-50 dark:text-zinc-300 dark:hover:bg-zinc-700/60' }}">{{ __('Notifications') }}</a>

                    <a href="{{ route('admin.communications.index') }}" wire:navigate class="block rounded-lg px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.communications.*') ? 'bg-zinc-100 text-zinc-900 dark:bg-zinc-700 dark:text-white' : 'text-zinc-700 hover:bg-zinc-50 dark:text-zinc-300 dark:hover:bg-zinc-700/60' }}">{{ __('Communications') }}</a>
                </nav>

                <!-- Sidebar Footer -->
                <div class="p-6 border-t border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center gap-3">
                        <div class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold">
                            {{ auth()->user()->initials() }}
                        </div>
                        <div class="min-w-0">
                            <div class="truncate text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ auth()->user()->fullName() }}</div>
                            <div class="truncate text-xs text-zinc-600 dark:text-zinc-400">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main content -->
            <div class="flex flex-1 flex-col overflow-hidden">
                <!-- Mobile Header -->
                <header class="flex items-center justify-between border-b border-zinc-200 bg-white px-4 py-3 dark:border-zinc-700 dark:bg-zinc-800 lg:hidden">
                    <button type="button" class="inline-flex items-center rounded-lg bg-zinc-100 px-3 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-200 dark:bg-zinc-700 dark:text-zinc-100 dark:hover:bg-zinc-600" @click="open = true">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        {{ __('Menu') }}
                    </button>
                    <x-app-logo />
                    <div class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-r from-blue-500 to-purple-600 text-white text-xs font-bold">{{ auth()->user()->initials() }}</div>
                </header>

                <!-- Main Content -->
                <main class="flex-1 overflow-y-auto bg-zinc-50 p-4 dark:bg-zinc-900 lg:p-8">
                    <div class="mx-auto w-full max-w-6xl">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>

