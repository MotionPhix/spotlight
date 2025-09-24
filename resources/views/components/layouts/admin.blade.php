<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-zinc-50 dark:bg-zinc-900">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-zinc-50 dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100" data-controller="theme">
        <div class="flex h-screen overflow-hidden" data-controller="menu">
            <!-- Mobile sidebar overlay -->
            <div data-menu-target="overlay" data-action="click->menu#hideOnOverlay" class="fixed inset-0 z-40 bg-black/40 lg:hidden hidden"></div>

            <!-- Sidebar (mobile drawer) -->
            <aside data-menu-target="menu" class="fixed inset-y-0 left-0 z-50 w-72 overflow-y-auto bg-white dark:bg-zinc-800 border-r border-zinc-200 dark:border-zinc-700 p-0 lg:hidden transform -translate-x-full transition-transform duration-300 ease-in-out hidden">
                <!-- Sidebar Header -->
                <div class="p-6 border-b border-zinc-200/50 dark:border-zinc-700/50">
                    <div class="flex items-center gap-3">
                        <div class="flex aspect-square size-10 items-center justify-center rounded-lg bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                                <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-zinc-900 dark:text-zinc-100">Spotlight Admin</div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-semibold bg-amber-100 text-amber-900 dark:bg-amber-900/50 dark:text-amber-200 shadow-sm">Admin Panel</span>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="p-6 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-900 dark:bg-blue-900/50 dark:text-blue-200' : 'text-zinc-700 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-700/60' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        {{ __('Dashboard') }}
                    </a>

                    <a href="{{ route('admin.users.index') }}" wire:navigate class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-900 dark:bg-blue-900/50 dark:text-blue-200' : 'text-zinc-700 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-700/60' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        {{ __('User Management') }}
                    </a>

                    <a href="{{ route('admin.notifications.index') }}" wire:navigate class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition-colors {{ request()->routeIs('admin.notifications.*') ? 'bg-blue-100 text-blue-900 dark:bg-blue-900/50 dark:text-blue-200' : 'text-zinc-700 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-700/60' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.868 12.354c-.235-.235-.235-.617 0-.852L13.132 3.238a1.2 1.2 0 011.696 0l1.934 1.934a1.2 1.2 0 010 1.696L8.498 15.132a1.2 1.2 0 01-1.696 0l-2.934-2.934z"></path>
                        </svg>
                        {{ __('Notifications') }}
                    </a>

                    <a href="{{ route('admin.communications.index') }}" wire:navigate class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition-colors {{ request()->routeIs('admin.communications.*') ? 'bg-blue-100 text-blue-900 dark:bg-blue-900/50 dark:text-blue-200' : 'text-zinc-700 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-700/60' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                        {{ __('Communications') }}
                    </a>
                </nav>
            </aside>

            <!-- Sidebar (desktop) -->
            <aside class="hidden lg:flex lg:w-72 lg:flex-col lg:border-r lg:border-zinc-200/50 lg:dark:border-zinc-700/50 lg:bg-white lg:dark:bg-zinc-800">
                <!-- Sidebar Header -->
                <div class="p-6 border-b border-zinc-200/50 dark:border-zinc-700/50">
                    <div class="flex items-center gap-3">
                        <div class="flex aspect-square size-10 items-center justify-center rounded-lg bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                                <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-zinc-900 dark:text-zinc-100">Spotlight Admin</div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-semibold bg-amber-100 text-amber-900 dark:bg-amber-900/50 dark:text-amber-200 shadow-sm">Admin Panel</span>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 p-6 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-900 dark:bg-blue-900/50 dark:text-blue-200' : 'text-zinc-700 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-700/60' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        {{ __('Dashboard') }}
                    </a>

                    <a href="{{ route('admin.users.index') }}" wire:navigate class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-900 dark:bg-blue-900/50 dark:text-blue-200' : 'text-zinc-700 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-700/60' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        {{ __('User Management') }}
                    </a>

                    <a href="{{ route('admin.notifications.index') }}" wire:navigate class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition-colors {{ request()->routeIs('admin.notifications.*') ? 'bg-blue-100 text-blue-900 dark:bg-blue-900/50 dark:text-blue-200' : 'text-zinc-700 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-700/60' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.868 12.354c-.235-.235-.235-.617 0-.852L13.132 3.238a1.2 1.2 0 011.696 0l1.934 1.934a1.2 1.2 0 010 1.696L8.498 15.132a1.2 1.2 0 01-1.696 0l-2.934-2.934z"></path>
                        </svg>
                        {{ __('Notifications') }}
                    </a>

                    <a href="{{ route('admin.communications.index') }}" wire:navigate class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition-colors {{ request()->routeIs('admin.communications.*') ? 'bg-blue-100 text-blue-900 dark:bg-blue-900/50 dark:text-blue-200' : 'text-zinc-700 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-700/60' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                        {{ __('Communications') }}
                    </a>
                </nav>

                <!-- Sidebar Footer -->
                <div class="p-6 border-t border-zinc-200/50 dark:border-zinc-700/50" data-controller="dropdown">
                    <button data-action="click->dropdown#toggle" class="flex items-center gap-3 w-full p-3 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700/60 transition-colors">
                        <div class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold shadow-lg">
                            {{ auth()->user()->initials() }}
                        </div>
                        <div class="min-w-0 flex-1 text-left">
                            <div class="truncate text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ auth()->user()->fullName() }}</div>
                            <div class="truncate text-xs text-zinc-600 dark:text-zinc-400">{{ auth()->user()->email }}</div>
                        </div>
                        <svg class="w-4 h-4 text-zinc-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div data-dropdown-target="menu" data-action="click->dropdown#preventClose" class="mt-2 bg-white/95 dark:bg-zinc-800/95 backdrop-blur-sm rounded-lg border border-zinc-200/50 dark:border-zinc-700/50 shadow-xl z-[100] transform opacity-0 scale-95 transition-all duration-200 ease-out hidden">
                        <div class="p-2 space-y-1">
                            <button
                                data-theme-target="toggle"
                                data-action="click->theme#toggle"
                                class="flex items-center gap-2 w-full px-3 py-2 text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-lg transition-colors text-left"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <!-- Default system icon -->
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="theme-text">System</span>
                            </button>
                            <div class="border-t border-zinc-200/50 dark:border-zinc-700/50 my-1"></div>
                            <a href="{{ route('home') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back to Main Site
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 w-full px-3 py-2 text-sm text-zinc-600 dark:text-zinc-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-lg transition-colors text-left">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Fallback Navigation (if JS fails) -->
            <div class="lg:hidden bg-zinc-800 text-white p-4 fixed top-0 left-0 right-0 z-50" style="display: none;" id="fallback-nav">
                <div class="flex items-center justify-between">
                    <span class="font-bold">Spotlight Admin</span>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.dashboard') }}" class="bg-zinc-700 px-3 py-1 rounded text-sm">Dashboard</a>
                        <a href="{{ route('admin.users.index') }}" class="bg-zinc-700 px-3 py-1 rounded text-sm">Users</a>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="flex flex-1 flex-col overflow-hidden" style="margin-top: 0;">
                <!-- Mobile Header -->
                <header class="flex items-center justify-between border-b border-zinc-200 bg-white px-4 py-3 dark:border-zinc-700 dark:bg-zinc-800 lg:hidden">
                    <!-- Hidden for now -->
                    <button type="button" data-action="click->menu#toggle" class="inline-flex items-center rounded-lg bg-zinc-100 px-3 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-200 dark:bg-zinc-700 dark:text-zinc-100 dark:hover:bg-zinc-600">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        {{ __('Menu') }}
                    </button>

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

                        <div class="flex aspect-square size-8 items-center justify-center rounded-lg bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                                <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                            </svg>
                        </div>

                        <div class="relative" data-controller="dropdown">
                            <button data-action="click->dropdown#toggle" class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-r from-blue-500 to-purple-600 text-white text-xs font-bold shadow-lg hover:shadow-xl transition-shadow">
                                {{ auth()->user()->initials() }}
                            </button>

                            <div data-dropdown-target="menu" data-action="click->dropdown#preventClose" class="absolute right-0 mt-2 w-48 origin-top-right rounded-lg bg-white/95 dark:bg-zinc-800/95 backdrop-blur-sm py-1 shadow-xl ring-1 ring-black/5 dark:ring-white/10 focus:outline-none z-[100] transform opacity-0 scale-95 transition-all duration-200 ease-out hidden">
                                <div class="px-4 py-3 border-b border-gray-200 dark:border-zinc-700">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ auth()->user()->fullName() }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                                </div>
                                <button
                                    data-theme-target="toggle"
                                    data-action="click->theme#toggle"
                                    class="flex w-full items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-700"
                                >
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <!-- Default system icon -->
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="theme-text">System</span>
                                </button>
                                <div class="border-t border-gray-200 dark:border-zinc-700 my-1"></div>
                                <a href="{{ route('home') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-700">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                    Back to Main Site
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-700">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Main Content -->
                <main class="flex-1 overflow-y-auto bg-zinc-50 p-4 dark:bg-zinc-900 lg:p-8">
                    <div class="mx-auto w-full max-w-6xl">
                        @yield('content', $slot ?? '')
                    </div>
                </main>
            </div>
        </div>
        @livewireScripts
    </body>
</html>

