<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="mt-10 space-y-6">
    <div class="relative mb-5">
        <h2 class="text-lg font-semibold">{{ __('Delete account') }}</h2>
        <p class="text-sm text-zinc-600 dark:text-zinc-300">{{ __('Delete your account and all of its resources') }}</p>
    </div>

    <x-bladewind::button
        uppercasing="false" color="red" class="w-fit"
        onclick="showModal('confirm-user-deletion')">
        {{ __('Delete account') }}
    </x-bladewind::button>

    <x-bladewind::modal name="confirm-user-deletion" title="{{ __('Are you sure you want to delete your account?') }}" size="small" ok_button_label="{{ __('Delete') }}" cancel_button_label="{{ __('Cancel') }}" ok_button_action="submitDeleteUser()">
        <div class="space-y-4">
            <p class="text-sm text-zinc-700 dark:text-zinc-300">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <x-bladewind::input wire:model="password" :label="__('Password')" type="password" />

            <script>
                function submitDeleteUser() {
                    window.Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id')).call('deleteUser');
                }
            </script>
        </div>
    </x-bladewind::modal>
</section>
