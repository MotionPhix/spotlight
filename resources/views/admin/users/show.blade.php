@extends('components.layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Header with Back Button -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.users.index') }}" class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 p-2 rounded-lg transition-colors">
                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $user->fullName() }}</h1>
                <p class="text-gray-600 dark:text-gray-300">User Details & Registration Information</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
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
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main User Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-gray-200/30 dark:border-gray-700/30">
                <div class="flex items-center mb-4">
                    <div class="w-6 h-6 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Personal Information</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">First Name</label>
                        <div class="text-gray-900 dark:text-gray-100 font-medium">{{ $user->first_name }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Last Name</label>
                        <div class="text-gray-900 dark:text-gray-100 font-medium">{{ $user->last_name }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Email</label>
                        <div class="text-gray-900 dark:text-gray-100 font-medium">{{ $user->email }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Phone</label>
                        <div class="text-gray-900 dark:text-gray-100 font-medium">{{ $user->phone ?? 'Not provided' }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Gender</label>
                        <div class="text-gray-900 dark:text-gray-100 font-medium">{{ $user->gender ? ucfirst($user->gender) : 'Not specified' }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Date of Birth</label>
                        <div class="text-gray-900 dark:text-gray-100 font-medium">{{ $user->date_of_birth ? $user->date_of_birth->format('M j, Y') : 'Not provided' }}</div>
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            @if($user->address || $user->city || $user->district)
            <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-gray-200/30 dark:border-gray-700/30">
                <div class="flex items-center mb-4">
                    <div class="w-6 h-6 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Address Information</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Address</label>
                        <div class="text-gray-900 dark:text-gray-100 font-medium">{{ $user->address ?? 'Not provided' }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">City</label>
                        <div class="text-gray-900 dark:text-gray-100 font-medium">{{ $user->city ?? 'Not provided' }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">District</label>
                        <div class="text-gray-900 dark:text-gray-100 font-medium">{{ $user->district ?? 'Not provided' }}</div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Avatar -->
            <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-gray-200/30 dark:border-gray-700/30 text-center">
                <div class="w-24 h-24 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-2xl mx-auto mb-4">
                    {{ $user->initials() }}
                </div>
                <h3 class="font-semibold text-gray-900 dark:text-gray-100">{{ $user->fullName() }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
            </div>

            <!-- Registration Details -->
            <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-gray-200/30 dark:border-gray-700/30">
                <div class="flex items-center mb-4">
                    <div class="w-6 h-6 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Registration</h3>
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Registration Date</label>
                        <div class="text-gray-900 dark:text-gray-100 font-medium">{{ $user->registered_at?->format('M j, Y') ?? $user->created_at->format('M j, Y') }}</div>
                    </div>

                    @if($user->amount_paid)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Amount Paid</label>
                        <div class="text-gray-900 dark:text-gray-100 font-bold text-lg">MWK {{ number_format($user->amount_paid, 2) }}</div>
                    </div>
                    @endif

                    @if($user->transaction_id)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Transaction ID</label>
                        <div class="text-gray-900 dark:text-gray-100 font-mono text-sm">{{ $user->transaction_id }}</div>
                    </div>
                    @endif

                    @if($user->payment_reference)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Payment Reference</label>
                        <div class="text-gray-900 dark:text-gray-100 font-mono text-sm">{{ $user->payment_reference }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Status Update -->
            <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-gray-200/30 dark:border-gray-700/30">
                <div class="flex items-center mb-4">
                    <div class="w-6 h-6 bg-gradient-to-r from-amber-500 to-orange-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Update Status</h3>
                </div>

                <form method="POST" action="{{ route('admin.users.update-status', $user) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Registration Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="pending" {{ $user->registration_status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $user->registration_status === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $user->registration_status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="payment_pending" {{ $user->registration_status === 'payment_pending' ? 'selected' : '' }}>Payment Pending</option>
                            <option value="completed" {{ $user->registration_status === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-xl transition-colors">
                        Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection