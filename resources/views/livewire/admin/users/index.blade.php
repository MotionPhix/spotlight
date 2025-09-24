<?php

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new #[Layout('components.layouts.admin')] class extends Component {
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $selectedUser = null;
    public $showUserModal = false;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function showUser($userId)
    {
        $this->selectedUser = User::find($userId);
        $this->showUserModal = true;
    }

    public function closeModal()
    {
        $this->showUserModal = false;
        $this->selectedUser = null;
    }

    public function updateUserStatus($userId, $status)
    {
        $user = User::find($userId);
        if ($user && !$user->isAdmin()) {
            $user->update(['registration_status' => $status]);
            $this->dispatch('user-updated');
        }
    }

    public function getUsersProperty()
    {
        return User::when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('registration_status', $this->statusFilter);
            })
            ->where('is_admin', false)
            ->latest()
            ->paginate(10);
    }
}; ?>
<div>
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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search Users</label>
                    <input
                        wire:model.live.debounce.300ms="search"
                        type="text"
                        placeholder="Search by name, email, or phone..."
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Status</label>
                    <select
                        wire:model.live="statusFilter"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="payment_pending">Payment Pending</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>
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
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $this->users->total() }} total users</div>
                </div>

                <div class="space-y-3">
                    @forelse ($this->users as $user)
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-600/50 rounded-xl p-4 border border-gray-200/30 dark:border-gray-600/30 hover:shadow-lg hover:scale-[1.01] transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4 flex-1">
                                    <!-- Avatar -->
                                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold shadow-lg">
                                        {{ $user->initials() }}
                                    </div>

                                    <!-- User Info -->
                                    <div class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <!-- Name & Contact -->
                                        <div>
                                            <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $user->fullName() }}</div>
                                            <div class="text-sm text-gray-600 dark:text-gray-300">{{ $user->email }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->phone }}</div>
                                        </div>

                                        <!-- Status -->
                                        <div class="flex items-center">
                                            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
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

                                        <!-- Payment Info -->
                                        <div>
                                            @if($user->amount_paid > 0)
                                                <div class="font-medium text-gray-900 dark:text-gray-100">MWK {{ number_format($user->amount_paid, 2) }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->payment_reference }}</div>
                                            @else
                                                <span class="text-gray-500 dark:text-gray-400">Not paid</span>
                                            @endif
                                        </div>

                                        <!-- Registration Date -->
                                        <div>
                                            <div class="text-sm text-gray-900 dark:text-gray-100">{{ $user->registered_at?->format('M j, Y') ?? 'Not registered' }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center space-x-2 ml-4">
                                    <a href="{{ route('admin.users.show', $user) }}" wire:navigate
                                       class="inline-flex items-center px-3 py-2 text-xs font-medium text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View
                                    </a>

                                    @if($user->registration_status === 'pending')
                                        <button wire:click="updateUserStatus({{ $user->id }}, 'approved')"
                                               class="inline-flex items-center px-3 py-2 text-xs font-medium text-green-700 bg-green-100 rounded-lg hover:bg-green-200 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Approve
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500 dark:text-gray-700">No users found matching your criteria.</p>
                        </div>
                    @endforelse
                </div>
            </div>


            @if($this->users->hasPages())
                <div class="px-6 py-4 border-t border-gray-200/60">
                    {{ $this->users->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- User Details Modal -->
    @if($showUserModal && $selectedUser)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" wire:click="closeModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block px-6 pt-5 pb-4 overflow-hidden text-left align-bottom bg-white/90 backdrop-blur-sm rounded-2xl shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full sm:p-6 border border-gray-200/60">
                    <div class="text-xl font-semibold mb-4">{{ $selectedUser->fullName() }}</div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="text-sm text-gray-500 dark:text-gray-600">Email</div>
                            <div class="font-medium text-gray-900 dark:text-gray-900">{{ $selectedUser->email }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500 dark:text-gray-600">Phone</div>
                            <div class="font-medium text-gray-900 dark:text-gray-900">{{ $selectedUser->phone }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500 dark:text-gray-600">Location</div>
                            <div class="font-medium text-gray-900 dark:text-gray-900">{{ $selectedUser->location ?? 'Not provided' }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500 dark:text-gray-600">Registration Status</div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                {{ match($selectedUser->registration_status) {
                                    'completed' => 'bg-emerald-100 text-emerald-800',
                                    'payment_pending' => 'bg-amber-100 text-amber-800',
                                    'approved' => 'bg-blue-100 text-blue-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800'
                                } }}">
                                {{ ucfirst(str_replace('_', ' ', $selectedUser->registration_status)) }}
                            </span>
                        </div>
                    </div>

                    @if($selectedUser->interests)
                        <div class="mt-4">
                            <div class="text-sm text-gray-500 dark:text-gray-600 mb-2">Interests</div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($selectedUser->interests as $interest)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $interest }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($selectedUser->current_knowledge)
                        <div class="mt-4">
                            <div class="text-sm text-gray-500 dark:text-gray-600 mb-2">Current Knowledge</div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($selectedUser->current_knowledge as $knowledge)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $knowledge }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($selectedUser->amount_paid > 0)
                        <div class="mt-4">
                            <div class="text-sm text-gray-500 dark:text-gray-600">Payment Information</div>
                            <div class="font-medium text-gray-900 dark:text-gray-900">Amount: MWK {{ number_format($selectedUser->amount_paid, 2) }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-600">Reference: {{ $selectedUser->payment_reference }}</div>
                        </div>
                    @endif

                    @if($selectedUser->registration_status === 'pending')
                        <div class="pt-4">
                            <button
                                onclick="$wire.updateUserStatus({{ $selectedUser->id }}, 'approved')"
                                class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-200"
                            >
                                Approve Registration
                            </button>
                        </div>
                    @endif

                    <div class="mt-6 flex justify-end space-x-2">
                        <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200" wire:click="closeModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
