<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-gradient-to-b dark:from-neutral-950 dark:to-neutral-900">
        <!-- Mobile-first responsive layout -->
        <div class="min-h-screen flex flex-col lg:flex-row">
            
            <!-- Left Panel - Hidden on mobile, visible on desktop -->
            <div class="hidden lg:flex lg:w-1/2 xl:w-2/5 relative bg-neutral-900 text-white">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-indigo-700 opacity-90"></div>
                <div class="relative z-10 flex flex-col justify-between p-8 xl:p-12">
                    
                    <!-- Logo/Brand -->
                    <div>
                        <a href="{{ route('home') }}" class="flex items-center text-xl font-semibold" wire:navigate>
                            <span class="flex h-10 w-10 items-center justify-center rounded-md bg-white/10 mr-3">
                                <x-app-logo-icon class="h-6 w-6 fill-current text-white" />
                            </span>
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>

                    <!-- Inspirational Quote -->
                    @php
                        [$message, $author] = str(Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');
                    @endphp
                    
                    <div class="py-8">
                        <blockquote class="space-y-4">
                            <flux:heading size="xl" class="leading-relaxed">&ldquo;{{ trim($message) }}&rdquo;</flux:heading>
                            <footer>
                                <flux:heading size="lg" class="text-white/80">{{ trim($author) }}</flux:heading>
                            </footer>
                        </blockquote>
                    </div>

                    <!-- Features/Benefits -->
                    <div class="space-y-4 text-sm text-white/90">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>6 Months Professional Training</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Industry-Standard Equipment</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Hands-on Learning Experience</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel - Full width on mobile, half width on desktop -->
            <div class="flex-1 lg:w-1/2 xl:w-3/5 w-full min-w-0">
                <div class="min-h-screen flex items-center justify-center p-2 sm:p-4 md:p-6 lg:p-8 w-full">
                    <div class="w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg xl:max-w-xl space-y-6 min-w-0">
                        
                        <!-- Mobile Logo -->
                        <div class="text-center lg:hidden">
                            <a href="{{ route('home') }}" class="inline-flex flex-col items-center gap-3 font-medium" wire:navigate>
                                <span class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-600">
                                    <x-app-logo-icon class="h-7 w-7 fill-current text-white" />
                                </span>
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ config('app.name', 'Laravel') }}</span>
                            </a>
                        </div>

                        <!-- Form Content -->
                        <div class="w-full">
                            {{ $slot }}
                        </div>
                        
                        <!-- Mobile Benefits -->
                        <div class="lg:hidden bg-gray-50 dark:bg-gray-800/50 rounded-lg p-4">
                            <div class="grid grid-cols-1 gap-3 text-sm text-gray-600 dark:text-gray-400">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>6 Months Professional Training</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Industry-Standard Equipment</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Hands-on Learning Experience</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>