<?php

use App\Models\User;
use App\Services\PayChanguService;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.checkout')] class extends Component {
    public User $user;
    public bool $processing = false;

    public function mount(): void
    {
        $userId = session('registered_user_id');

        if (!$userId) {
            $this->redirect(route('register'), navigate: true);
            return;
        }

        $this->user = User::findOrFail($userId);

        // If already paid, redirect to success page
        if ($this->user->registration_status === 'completed') {
            $this->redirect(route('home'), navigate: true);
            return;
        }
    }

    public function processPayment(): void
    {
        $this->processing = true;

        try {
            $paychangu = new PayChanguService();
            $txRef = $paychangu->generateTxRef($this->user->id);

            // Update user with payment reference
            $this->user->update([
                'payment_reference' => $txRef,
                'registration_status' => 'payment_pending'
            ]);

            $paymentData = [
                'tx_ref' => $txRef,
                'amount' => 5000, // MWK 5,000 registration fee
                'currency' => 'MWK',
                'email' => $this->user->email,
                'phone_number' => $this->user->phone,
                'full_name' => $this->user->fullName(),
                'callback_url' => route('payment.webhook'),
                'return_url' => route('home') . '?payment=success',
                'branch' => 'Spotlight Consultancy',
            ];

            $result = $paychangu->createPayment($paymentData);

            if ($result['success']) {
                // Redirect to PayChangu payment page
                $this->redirect($result['link']);
                return;
            }

            session()->flash('error', 'Failed to create payment: ' . $result['error']);
            $this->processing = false;

        } catch (\Exception $e) {
            session()->flash('error', 'Payment processing error: ' . $e->getMessage());
            $this->processing = false;
        }
    }

    public function goBack(): void
    {
        $this->redirect(route('register'), navigate: true);
    }
}; ?>

<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Complete Registration Payment</h1>
            <p class="text-lg text-gray-600 dark:text-gray-300">Pay the registration fee to secure your application for review</p>
        </div>

        <!-- Error Messages -->
        @if(session('error'))
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-red-700 dark:text-red-300 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-8">

            <!-- Application Summary -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Applicant Information -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Application Details</h2>

                    <dl class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Full Name</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $user->fullName() }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $user->phone }}</dd>
                        </div>

                        @if($user->email)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $user->email }}</dd>
                        </div>
                        @endif

                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Location</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $user->location }}</dd>
                        </div>

                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Areas of Interest</dt>
                            <dd class="flex flex-wrap gap-2">
                                @foreach($user->interests as $interest)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                        @switch($interest)
                                            @case('graphic_design') Graphic Design @break
                                            @case('large_format_printing') Large Format Printing @break
                                            @case('embroidery_digitization') Embroidery & Digitization @break
                                            @case('screen_printing') Screen Printing @break
                                            @case('signage_branding') Signage & Branding @break
                                            @case('machine_troubleshooting') Machine Troubleshooting @break
                                            @default {{ $interest }}
                                        @endswitch
                                    </span>
                                @endforeach
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Program Information -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Program Information</h2>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                            <span class="font-medium text-gray-900 dark:text-white">Artisan Skills Training Program</span>
                            <span class="text-gray-600 dark:text-gray-300">6 months</span>
                        </div>

                        <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                            <span class="font-medium text-gray-900 dark:text-white">Training Location</span>
                            <span class="text-gray-600 dark:text-gray-300">Area 45, Chinsapo, Lilongwe</span>
                        </div>

                        <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                            <span class="font-medium text-gray-900 dark:text-white">Program Type</span>
                            <span class="text-gray-600 dark:text-gray-300">Hands-on Consultancy Training</span>
                        </div>

                        <div class="flex justify-between items-center py-3">
                            <span class="font-medium text-gray-900 dark:text-white">Training Provider</span>
                            <span class="text-blue-600 dark:text-blue-400 font-semibold">Spotlight Consultancy</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Section -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 sticky top-8">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Payment Summary</h2>

                    <!-- Pricing -->
                    <div class="space-y-4 mb-6">
                        <div class="grid">
                            <span class="text-gray-600 dark:text-gray-300">Registration Fee</span>
                            <span class="font-medium text-gray-900 dark:text-white">MWK 5,000</span>
                        </div>

                        <div class="grid">
                            <span class="text-gray-600 dark:text-gray-300">Processing Fee</span>
                            <span class="font-medium text-gray-900 dark:text-white">MWK 0</span>
                        </div>

                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <div class="grid">
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">Total Due Now</span>
                                <span class="text-lg font-bold text-blue-600 dark:text-blue-400">MWK 5,000</span>
                            </div>
                        </div>

                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-3 text-xs text-blue-800 dark:text-blue-200">
                            <p><strong>Note:</strong> This is only the registration fee. The full program fee (MWK 300,000) will be discussed after your application is reviewed.</p>
                        </div>
                    </div>

                    <!-- Payment Button -->
                    <div class="space-y-4">
                        <button
                            wire:click="processPayment"
                            wire:loading.attr="disabled"
                            class="w-full bg-blue-600 hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center justify-center"
                        >
                            <span wire:loading.remove wire:target="processPayment">
                                Pay Now
                            </span>
                            <span wire:loading wire:target="processPayment" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            </span>
                        </button>

                        <button
                            wire:click="goBack"
                            class="w-full border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 px-6 py-3 rounded-lg font-medium transition-colors"
                        >
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
