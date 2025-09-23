<?php

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin')] class extends Component {
    public function getStatsProperty()
    {
        return [
            'total_users' => User::count(),
            'pending_registrations' => User::where('registration_status', 'pending')->count(),
            'completed_registrations' => User::where('registration_status', 'completed')->count(),
            'payment_pending' => User::where('registration_status', 'payment_pending')->count(),
            'total_revenue' => User::where('registration_status', 'completed')->sum('amount_paid'),
        ];
    }
};
?>

<div>
    <div class="space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl shadow-lg mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent dark:from-gray-900 dark:to-gray-600">Admin Dashboard</h1>
            <p class="text-lg text-gray-600 dark:text-gray-700 mt-2">Manage your artisan course registrations and users</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
            <div class="bg-white/70 dark:bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-gray-200/60 hover:shadow-2xl hover:scale-105 transition-all duration-300">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <x-icon name="users" class="w-6 h-6 text-white" />
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-600">Total Users</div>
                        <div class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-500 bg-clip-text text-transparent">{{ $this->stats['total_users'] }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-600">All registered users</div>
                    </div>
                </div>
            </div>

            <div class="bg-white/70 dark:bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-gray-200/60 hover:shadow-2xl hover:scale-105 transition-all duration-300">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-amber-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg">
                        <x-icon name="clock" class="w-6 h-6 text-white" />
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-600">Pending</div>
                        <div class="text-2xl font-bold bg-gradient-to-r from-amber-600 to-orange-500 bg-clip-text text-transparent">{{ $this->stats['pending_registrations'] }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-600">Awaiting approval</div>
                    </div>
                </div>
            </div>

            <div class="bg-white/70 dark:bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-gray-200/60 hover:shadow-2xl hover:scale-105 transition-all duration-300">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-green-500 rounded-xl flex items-center justify-center shadow-lg">
                        <x-icon name="check-circle" class="w-6 h-6 text-white" />
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-600">Completed</div>
                        <div class="text-2xl font-bold bg-gradient-to-r from-emerald-600 to-green-500 bg-clip-text text-transparent">{{ $this->stats['completed_registrations'] }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-600">Fully registered</div>
                    </div>
                </div>
            </div>

            <div class="bg-white/70 dark:bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-gray-200/60 hover:shadow-2xl hover:scale-105 transition-all duration-300">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg">
                        <x-icon name="credit-card" class="w-6 h-6 text-white" />
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-600">Payment Pending</div>
                        <div class="text-2xl font-bold bg-gradient-to-r from-orange-600 to-red-500 bg-clip-text text-transparent">{{ $this->stats['payment_pending'] }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-600">Awaiting payment</div>
                    </div>
                </div>
            </div>

            <div class="bg-white/70 dark:bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-gray-200/60 hover:shadow-2xl hover:scale-105 transition-all duration-300">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                        <x-icon name="banknotes" class="w-6 h-6 text-white" />
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-600">Total Revenue</div>
                        <div class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-500 bg-clip-text text-transparent">MWK {{ number_format($this->stats['total_revenue'], 2) }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-600">All time earnings</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white/70 dark:bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-xl border border-gray-200/60">
            <div class="flex items-center mb-6">
                <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-900">Quick Actions</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.users.index') }}" wire:navigate class="group">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-50 dark:to-indigo-50 rounded-xl p-6 border border-blue-200/60 hover:shadow-lg hover:scale-105 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                                <x-icon name="users" class="w-5 h-5 text-white" />
                            </div>
                            <div class="ml-4">
                                <div class="font-semibold text-blue-900">Manage Users</div>
                                <div class="text-sm text-blue-600">View and manage registrations</div>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.communications.index') }}" wire:navigate class="group">
                    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-50 dark:to-teal-50 rounded-xl p-6 border border-emerald-200/60 hover:shadow-lg hover:scale-105 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-md">
                                <x-icon name="chat-bubble-left-right" class="w-5 h-5 text-white" />
                            </div>
                            <div class="ml-4">
                                <div class="font-semibold text-emerald-900">Send Communication</div>
                                <div class="text-sm text-emerald-600">Email users and notifications</div>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.notifications.index') }}" wire:navigate class="group">
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-50 dark:to-orange-50 rounded-xl p-6 border border-amber-200/60 hover:shadow-lg hover:scale-105 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-r from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-md">
                                <x-icon name="bell" class="w-5 h-5 text-white" />
                            </div>
                            <div class="ml-4">
                                <div class="font-semibold text-amber-900">View Notifications</div>
                                <div class="text-sm text-amber-600">Monitor system alerts</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Registrations -->
        <div class="bg-white/70 dark:bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-xl border border-gray-200/60">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-rose-500 to-pink-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-900">Recent Registrations</h3>
                </div>
                <a href="{{ route('admin.users.index') }}" wire:navigate class="text-sm text-blue-600 hover:text-blue-700 font-medium">View all →</a>
            </div>
            <div class="space-y-3">
                @forelse (User::latest()->where('registration_status', '!=', 'pending')->limit(5)->get() as $user)
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-50 dark:to-white rounded-xl border border-gray-200/60 hover:shadow-md transition-all duration-200">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold shadow-lg">
                                {{ $user->initials() }}
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900 dark:text-gray-900">{{ $user->fullName() }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-600">{{ $user->email }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                {{ $user->registration_status === 'completed'
                                    ? 'bg-emerald-100 text-emerald-800'
                                    : ($user->registration_status === 'payment_pending'
                                        ? 'bg-amber-100 text-amber-800'
                                        : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst(str_replace('_', ' ', $user->registration_status)) }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-600 mt-1">{{ $user->registered_at?->diffForHumans() ?? $user->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-700">No registrations found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
