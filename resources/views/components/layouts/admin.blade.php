<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-100 dark:to-gray-200">
        <div class="flex h-screen">
            <!-- Sidebar -->
            <aside class="w-72 bg-white/80 dark:bg-white/90 backdrop-blur-sm border-r border-gray-200/60 dark:border-gray-300/60 flex flex-col shadow-xl">
                <!-- Sidebar Header -->
                <div class="p-6 border-b border-gray-200/60 dark:border-gray-300/60">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900 dark:text-gray-900">Spotlight</div>
                            <x-bladewind::tag bg_color="orange" size="small">Admin Panel</x-bladewind::tag>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 p-6">
                    <div class="mb-6">
                        <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-600 uppercase tracking-wider mb-4">
                            {{ __('Administration') }}
                        </h3>
                    </div>

                    <div class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}" wire:navigate
                           class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg shadow-blue-500/25' : 'text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 dark:text-gray-800 dark:hover:bg-gradient-to-r dark:hover:from-gray-50 dark:hover:to-white' }}">
                            <div class="w-6 h-6 mr-3 flex items-center justify-center">
                                <x-icon name="home" class="w-4 h-4" />
                            </div>
                            {{ __('Dashboard') }}
                        </a>

                        <a href="{{ route('admin.users.index') }}" wire:navigate
                           class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg shadow-blue-500/25' : 'text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 dark:text-gray-800 dark:hover:bg-gradient-to-r dark:hover:from-gray-50 dark:hover:to-white' }}">
                            <div class="w-6 h-6 mr-3 flex items-center justify-center">
                                <x-icon name="users" class="w-4 h-4" />
                            </div>
                            {{ __('User Management') }}
                        </a>

                        <a href="{{ route('admin.notifications.index') }}" wire:navigate
                           class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.notifications.*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg shadow-blue-500/25' : 'text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 dark:text-gray-800 dark:hover:bg-gradient-to-r dark:hover:from-gray-50 dark:hover:to-white' }}">
                            <div class="w-6 h-6 mr-3 flex items-center justify-center">
                                <x-icon name="bell" class="w-4 h-4" />
                            </div>
                            {{ __('Notifications') }}
                        </a>

                        <a href="{{ route('admin.communications.index') }}" wire:navigate
                           class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.communications.*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg shadow-blue-500/25' : 'text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 dark:text-gray-800 dark:hover:bg-gradient-to-r dark:hover:from-gray-50 dark:hover:to-white' }}">
                            <div class="w-6 h-6 mr-3 flex items-center justify-center">
                                <x-icon name="chat-bubble-left-right" class="w-4 h-4" />
                            </div>
                            {{ __('Communications') }}
                        </a>
                    </div>
                </nav>

                <!-- Sidebar Footer -->
                <div class="p-6 border-t border-gray-200/60 dark:border-gray-300/60">
                    <!-- Desktop User Profile -->
                    <div class="flex items-center bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-50 dark:to-white rounded-xl">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-sm shadow-lg">
                            {{ auth()->user()->initials() }}
                        </div>
                        <div class="ml-3 flex-1">
                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-900">{{ auth()->user()->fullName() }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-600">{{ auth()->user()->email }}</div>
                        </div>

                        <div class="ml-2">
                            {{-- <x-bladewind::dropmenu>
                                <x-bladewind::dropmenu.item>
                                    <a href="{{ route('settings.profile') }}" wire:navigate class="flex items-center">
                                        <x-icon name="cog-6-tooth" class="w-4 h-4 mr-2" />
                                        {{ __('Settings') }}
                                    </a>
                                </x-bladewind::dropmenu.item>
                                <x-bladewind::dropmenu.item>
                                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full">
                                            <x-icon name="arrow-right-start-on-rectangle" class="w-4 h-4 mr-2" />
                                            {{ __('Log Out') }}
                                        </button>
                                    </form>
                                </x-bladewind::dropmenu.item>
                            </x-bladewind::dropmenu> --}}

                            <x-ui.dropdown-menu>
                                <a
                                    wire.navigate
                                    href="{{ route('settings.profile') }}" class="flex items-center px-4 py-2 hover:bg-[--color-muted] space-x-2">
                                    <x-icon name="user" class="w-4 h-4" />
                                    <span>Profile</span>
                                </a>

                                <a href="{{ route('logout') }}" class="flex items-center px-4 py-2 hover:bg-[--color-muted] space-x-2">
                                    <x-icon name="cog" class="w-4 h-4" />
                                    <span>Settings</span>
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-left hover:bg-[--color-destructive] text-[--color-destructive-foreground] space-x-2">
                                    <x-icon name="logout" class="w-4 h-4" />
                                    <span>Logout</span>
                                    </button>
                                </form>
                            </x-ui.dropdown-menu>

                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Mobile Header -->
                <header class="lg:hidden bg-white dark:bg-gray-200 border-b border-gray-200 dark:border-gray-300">
                    <div class="px-4 py-3 flex items-center justify-between">
                        <x-bladewind::button type="secondary" size="small" icon="bars-3">Menu</x-bladewind::button>
                        <x-app-logo />
                        <x-bladewind::avatar label="{{ auth()->user()->initials() }}" size="tiny" />
                    </div>
                </header>

                <!-- Main Content -->
                <main class="flex-1 overflow-y-auto bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-100 dark:to-gray-200">
                    <div class="p-8">
                        <div class="max-w-4xl mx-auto">
                            {{ $slot }}
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>

@push('components')
    @php
    $trigger = '<img src="/vendor/bladewind/icons/solid/x-circle.svg" class="w-8 h-8 rounded-full" alt="User Avatar">'
    @endphp
@endpush
