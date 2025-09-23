<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <nav class="rounded-lg border border-zinc-200 bg-white p-2 text-sm dark:border-zinc-700 dark:bg-zinc-800">
            <a href="{{ route('settings.profile') }}" wire:navigate
               class="block rounded-md px-3 py-2 {{ request()->routeIs('settings.profile') ? 'bg-zinc-100 text-zinc-900 dark:bg-zinc-700 dark:text-white' : 'text-zinc-700 hover:text-zinc-900 dark:text-zinc-300 dark:hover:text-white' }}">
                {{ __('Profile') }}
            </a>
            <a href="{{ route('settings.password') }}" wire:navigate
               class="block rounded-md px-3 py-2 {{ request()->routeIs('settings.password') ? 'bg-zinc-100 text-zinc-900 dark:bg-zinc-700 dark:text-white' : 'text-zinc-700 hover:text-zinc-900 dark:text-zinc-300 dark:hover:text-white' }}">
                {{ __('Password') }}
            </a>
            <a href="{{ route('settings.appearance') }}" wire:navigate
               class="block rounded-md px-3 py-2 {{ request()->routeIs('settings.appearance') ? 'bg-zinc-100 text-zinc-900 dark:bg-zinc-700 dark:text-white' : 'text-zinc-700 hover:text-zinc-900 dark:text-zinc-300 dark:hover:text-white' }}">
                {{ __('Appearance') }}
            </a>
        </nav>
    </div>

    <div class="hidden h-px w-full bg-zinc-200 dark:bg-zinc-700 md:hidden"></div>

    <div class="flex-1 self-stretch max-md:pt-6">
        @if (! empty($heading))
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $heading }}</h2>
        @endif
        @if (! empty($subheading))
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-300">{{ $subheading }}</p>
        @endif

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
