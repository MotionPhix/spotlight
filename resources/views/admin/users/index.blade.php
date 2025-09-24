@extends('components.layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl shadow-lg mb-4">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>
        <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent dark:from-white dark:to-gray-300">User Management</h1>
        <p class="text-lg text-gray-600 dark:text-gray-300 mt-2">Manage artisan course registrations and users</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-gray-200/30 dark:border-gray-700/30">
        <div class="flex items-center mb-4">
            <div class="w-6 h-6 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Search & Filter</h3>
        </div>

        <form method="GET" data-controller="search" data-search-target="form" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search Users</label>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by name, email, or phone..."
                    data-search-target="searchInput"
                    data-action="input->search#searchInputChanged"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Status</label>
                <select
                    name="status"
                    data-search-target="statusSelect"
                    data-action="change->search#statusChanged"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="payment_pending" {{ request('status') === 'payment_pending' ? 'selected' : '' }}>Payment Pending</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-xl transition-colors">
                    Search
                </button>
                <button
                    type="button"
                    data-search-target="clearButton"
                    data-action="click->search#clear"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-xl transition-colors {{ !request('search') && !request('status') ? 'hidden' : '' }}"
                >
                    Clear
                </button>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-200/30 dark:border-gray-700/30 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="w-6 h-6 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h6a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Users Directory</h3>
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $users->total() }} total users</div>
            </div>

            <div class="space-y-3">
                @forelse ($users as $user)
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-600/50 rounded-xl p-4 border border-gray-200/30 dark:border-gray-600/30 hover:shadow-lg hover:scale-[1.01] transition-all duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4 flex-1">
                                <!-- Avatar -->
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold shadow-lg">
                                    {{ $user->initials() }}
                                </div>

                                <!-- User Info -->
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $user->fullName() }}</div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                            {{ $user->registration_status === 'completed'
                                                ? 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300'
                                                : ($user->registration_status === 'payment_pending'
                                                    ? 'bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-300'
                                                    : ($user->registration_status === 'approved'
                                                        ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300'
                                                        : ($user->registration_status === 'rejected'
                                                            ? 'bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300'
                                                            : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300'))) }}">
                                            {{ ucfirst(str_replace('_', ' ', $user->registration_status)) }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">{{ $user->email }}</div>
                                    @if($user->phone)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->phone }}</div>
                                    @endif
                                </div>
                            </div>

                            <!-- Payment Info -->
                            <div class="text-right mr-4">
                                @if($user->amount_paid)
                                    <div class="font-bold text-gray-900 dark:text-gray-100">MWK {{ number_format($user->amount_paid, 2) }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->transaction_id ?? 'No TX ID' }}</div>
                                @else
                                    <div class="text-sm text-gray-500 dark:text-gray-400">No payment</div>
                                @endif
                            </div>

                            <!-- Date -->
                            <div class="text-right mr-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $user->registered_at?->format('M j, Y') ?? $user->created_at->format('M j, Y') }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->registered_at?->diffForHumans() ?? $user->created_at->diffForHumans() }}</div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2">
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400">No users found.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection