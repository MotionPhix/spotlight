<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<section class="w-full" x-data="appearanceSettings()">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Appearance')" :subheading=" __('Update the appearance settings for your account')">
        <div class="inline-flex rounded-lg border border-zinc-200 bg-white p-1 text-sm dark:border-zinc-700 dark:bg-zinc-800">
            <button type="button" @click="setTheme('light')" :class="btnClass('light')" class="rounded-md px-3 py-2">{{ __('Light') }}</button>
            <button type="button" @click="setTheme('dark')" :class="btnClass('dark')" class="rounded-md px-3 py-2">{{ __('Dark') }}</button>
            <button type="button" @click="setTheme('system')" :class="btnClass('system')" class="rounded-md px-3 py-2">{{ __('System') }}</button>
        </div>

        <p class="mt-3 text-xs text-zinc-600 dark:text-zinc-300">{{ __('Your choice is saved on this device.') }}</p>
    </x-settings.layout>
</section>

<script>
function appearanceSettings() {
    return {
        mode: localStorage.getItem('theme') || 'system',
        setTheme(mode) {
            this.mode = mode;
            localStorage.setItem('theme', mode);
            const root = document.documentElement;
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isDark = mode === 'system' ? prefersDark : mode === 'dark';
            root.classList.toggle('dark', isDark);
        },
        btnClass(mode) {
            const active = this.mode === mode;
            return (active ? 'bg-zinc-100 text-zinc-900 dark:bg-zinc-700 dark:text-white' : 'text-zinc-700 dark:text-zinc-300');
        },
        init() { this.setTheme(this.mode); }
    }
}
</script>
