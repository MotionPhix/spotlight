<?php

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin')] class extends Component {
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function updateUserStatus($status)
    {
        if (!$this->user->isAdmin()) {
            $this->user->update(['registration_status' => $status]);
            $this->dispatch('user-updated');
            session()->flash('message', 'User status updated successfully!');
        }
    }

    public function deleteUser()
    {
        if (!$this->user->isAdmin()) {
            $this->user->delete();
            return redirect()->route('admin.users.index')->with('message', 'User deleted successfully!');
        }
    }
}; ?>

<div class="space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.users.index') }}" wire:navigate
               class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-white rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Users
            </a>

            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">{{ $user->fullName() }}</h1>
                <p class="text-gray-600 dark:text-gray-700">User Details & Registration Information</p>
            </div>
        </div>

        <div class="flex items-center space-x-3">
            @if($user->registration_status === 'pending')
                <button wire:click="updateUserStatus('approved')"
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-700 bg-green-100 rounded-lg hover:bg-green-200 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Approve User
                </button>
            @endif

            @if(!$user->isAdmin())
                <button wire:click="deleteUser" wire:confirm="Are you sure you want to delete this user? This action cannot be undone."
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete User
                </button>
            @endif
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Personal Information -->
            <div class="bg-white/70 dark:bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-xl border border-gray-200/60">
                <div class="flex items-center mb-6">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Personal Information</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-600">First Name</label>
                        <div class="mt-1 text-lg font-semibold text-gray-900">{{ $user->first_name }}</div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-600">Last Name</label>
                        <div class="mt-1 text-lg font-semibold text-gray-900">{{ $user->last_name }}</div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-600">Email Address</label>
                        <div class="mt-1 text-lg font-semibold text-gray-900">{{ $user->email }}</div>
                        @if($user->email_verified_at)
                            <div class="mt-1 inline-flex items-center text-xs text-emerald-600">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Verified
                            </div>
                        @else
                            <div class="mt-1 inline-flex items-center text-xs text-amber-600">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                Not verified
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-600">Phone Number</label>
                        <div class="mt-1 text-lg font-semibold text-gray-900">{{ $user->phone }}</div>
                        @if($user->phone_verified_at)
                            <div class="mt-1 inline-flex items-center text-xs text-emerald-600">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Verified
                            </div>
                        @endif
                    </div>

                    @if($user->location)
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-600">Location</label>
                        <div class="mt-1 text-lg font-semibold text-gray-900">{{ $user->location }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Interests & Knowledge -->
            @if($user->interests || $user->current_knowledge)
            <div class="bg-white/70 dark:bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-xl border border-gray-200/60">
                <div class="flex items-center mb-6">
                    <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Interests & Knowledge</h3>
                </div>

                @if($user->interests)
                <div class="mb-6">
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-600 mb-3 block">Areas of Interest</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($user->interests as $interest)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $interest }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($user->current_knowledge)
                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-600 mb-3 block">Current Knowledge</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($user->current_knowledge as $knowledge)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                {{ $knowledge }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
            <!-- Status Card -->
            <div class="bg-white/70 dark:bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-gray-200/60">
                <div class="flex items-center mb-4">
                    <div class="w-6 h-6 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Registration Status</h3>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Current Status</span>
                        <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ match($user->registration_status) {
                                'completed' => 'bg-emerald-100 text-emerald-800',
                                'payment_pending' => 'bg-amber-100 text-amber-800',
                                'approved' => 'bg-blue-100 text-blue-800',
                                'rejected' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-100 text-gray-800'
                            } }}">
                            {{ ucfirst(str_replace('_', ' ', $user->registration_status)) }}
                        </div>
                    </div>

                    @if($user->registered_at)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Registered</span>
                        <span class="text-sm font-medium text-gray-900">{{ $user->registered_at->format('M j, Y') }}</span>
                    </div>
                    @endif

                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Account Created</span>
                        <span class="text-sm font-medium text-gray-900">{{ $user->created_at->format('M j, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            @if($user->amount_paid > 0 || $user->payment_reference)
            <div class="bg-white/70 dark:bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-gray-200/60">
                <div class="flex items-center mb-4">
                    <div class="w-6 h-6 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Payment Information</h3>
                </div>

                <div class="space-y-3">
                    @if($user->amount_paid > 0)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Amount Paid</span>
                        <span class="text-lg font-bold text-green-600">MWK {{ number_format($user->amount_paid, 2) }}</span>
                    </div>
                    @endif

                    @if($user->payment_reference)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Reference</span>
                        <span class="text-sm font-mono text-gray-900 bg-gray-100 px-2 py-1 rounded">{{ $user->payment_reference }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Avatar -->
            <div class="bg-white/70 dark:bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-gray-200/60 text-center">
                <div class="w-24 h-24 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4 shadow-lg">
                    {{ $user->initials() }}
                </div>
                <h4 class="text-lg font-semibold text-gray-900">{{ $user->fullName() }}</h4>
                <p class="text-sm text-gray-600">User ID: {{ $user->id }}</p>
            </div>
        </div>
    </div>
</div>