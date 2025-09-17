<?php

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new #[Layout('components.layouts.admin')] class extends Component {
    use WithPagination;

    public $filterType = '';
    public $filterUser = '';

    public function updatedFilterType()
    {
        $this->resetPage();
    }

    public function updatedFilterUser()
    {
        $this->resetPage();
    }

    public function markAsRead($notificationId)
    {
        DB::table('notifications')
            ->where('id', $notificationId)
            ->update(['read_at' => now()]);
    }

    public function markAllAsRead()
    {
        DB::table('notifications')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function deleteNotification($notificationId)
    {
        DB::table('notifications')
            ->where('id', $notificationId)
            ->delete();
    }

    public function getNotificationsProperty()
    {
        return DB::table('notifications')
            ->leftJoin('users', 'notifications.notifiable_id', '=', 'users.id')
            ->when($this->filterType, function ($query) {
                $query->where('notifications.type', 'like', '%' . $this->filterType . '%');
            })
            ->when($this->filterUser, function ($query) {
                $query->where(function ($q) {
                    $q->where('users.first_name', 'like', '%' . $this->filterUser . '%')
                      ->orWhere('users.last_name', 'like', '%' . $this->filterUser . '%')
                      ->orWhere('users.email', 'like', '%' . $this->filterUser . '%');
                });
            })
            ->select(
                'notifications.*',
                'users.first_name',
                'users.last_name',
                'users.email'
            )
            ->orderBy('notifications.created_at', 'desc')
            ->paginate(15);
    }

    public function getStatsProperty()
    {
        return [
            'total' => DB::table('notifications')->count(),
            'unread' => DB::table('notifications')->whereNull('read_at')->count(),
            'recent' => DB::table('notifications')->where('created_at', '>=', now()->subDays(7))->count(),
        ];
    }
}; ?>
<div>
    <div class="space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-amber-500 to-orange-600 rounded-2xl shadow-lg mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM9 17h5l-5 5v-5zM13 3h4l-3 3 3 3h-4V3zM9 3H5l3 3-3 3h4V3z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent dark:from-gray-900 dark:to-gray-600">Notification Management</h1>
            <p class="text-lg text-gray-600 dark:text-gray-700 mt-2">Monitor and manage system notifications</p>

            <div class="mt-6">
                <button wire:click="markAllAsRead"
                        class="inline-flex items-center px-6 py-3 text-sm font-medium text-amber-700 bg-amber-100 rounded-xl hover:bg-amber-200 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Mark All as Read
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white/70 dark:bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-gray-200/60 hover:shadow-2xl hover:scale-105 transition-all duration-300">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <x-icon name="bell" class="w-6 h-6 text-white" />
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-600">Total Notifications</div>
                        <div class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-500 bg-clip-text text-transparent">{{ $this->stats['total'] }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-600">All time</div>
                    </div>
                </div>
            </div>

            <div class="bg-white/70 dark:bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-gray-200/60 hover:shadow-2xl hover:scale-105 transition-all duration-300">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg">
                        <x-icon name="exclamation-circle" class="w-6 h-6 text-white" />
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-600">Unread</div>
                        <div class="text-2xl font-bold bg-gradient-to-r from-orange-600 to-red-500 bg-clip-text text-transparent">{{ $this->stats['unread'] }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-600">Need attention</div>
                    </div>
                </div>
            </div>

            <div class="bg-white/70 dark:bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-gray-200/60 hover:shadow-2xl hover:scale-105 transition-all duration-300">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-green-500 rounded-xl flex items-center justify-center shadow-lg">
                        <x-icon name="clock" class="w-6 h-6 text-white" />
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-600">This Week</div>
                        <div class="text-2xl font-bold bg-gradient-to-r from-emerald-600 to-green-500 bg-clip-text text-transparent">{{ $this->stats['recent'] }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-600">Recent activity</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white/70 dark:bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-gray-200/60">
            <div class="flex items-center mb-4">
                <div class="w-6 h-6 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-900">Filter Notifications</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-bladewind::input
                    wire:model.live.debounce.300ms="filterType"
                    placeholder="e.g., AdminMessage, Registration..."
                    label="Filter by Type"
                />

                <x-bladewind::input
                    wire:model.live.debounce.300ms="filterUser"
                    placeholder="Search by name or email..."
                    label="Filter by User"
                />
            </div>
        </div>

        <!-- Notifications Table -->
        <div class="bg-white/70 dark:bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-200/60 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-6 h-6 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM9 17h5l-5 5v-5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-900">All Notifications</h3>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-600">{{ $this->notifications->total() }} total notifications</div>
                </div>

                <div class="space-y-3">
                    @forelse ($this->notifications as $notification)
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-50 dark:to-white rounded-xl p-4 border border-gray-200/60 hover:shadow-lg hover:scale-[1.01] transition-all duration-200 {{ $notification->read_at ? 'opacity-75' : '' }}">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-4 flex-1">
                                    <!-- Status Icon -->
                                    <div class="flex-shrink-0 mt-1">
                                        @if($notification->read_at)
                                            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        @else
                                            <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center space-x-3">
                                                <!-- User Info -->
                                                @if($notification->first_name)
                                                    <div>
                                                        <div class="font-semibold text-gray-900">{{ $notification->first_name }} {{ $notification->last_name }}</div>
                                                        <div class="text-sm text-gray-600">{{ $notification->email }}</div>
                                                    </div>
                                                @else
                                                    <div class="text-gray-500">User not found</div>
                                                @endif

                                                <!-- Type Badge -->
                                                <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ class_basename($notification->type) }}
                                                </div>
                                            </div>

                                            <!-- Timestamp -->
                                            <div class="text-right text-sm text-gray-500">
                                                <div>{{ \Carbon\Carbon::parse($notification->created_at)->format('M j, Y') }}</div>
                                                <div class="text-xs">{{ \Carbon\Carbon::parse($notification->created_at)->format('g:i A') }}</div>
                                            </div>
                                        </div>

                                        <!-- Message Content -->
                                        <div class="mb-3">
                                            @php
                                                $data = json_decode($notification->data, true);
                                            @endphp
                                            @if(isset($data['subject']))
                                                <div class="font-medium text-gray-900 mb-1">{{ $data['subject'] }}</div>
                                                <div class="text-gray-600">{{ Str::limit($data['message'] ?? '', 100) }}</div>
                                            @elseif(isset($data['message']))
                                                <div class="text-gray-900">{{ Str::limit($data['message'], 100) }}</div>
                                            @else
                                                <div class="text-gray-500 italic">No content available</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center space-x-2 ml-4">
                                    @if(!$notification->read_at)
                                        <button wire:click="markAsRead('{{ $notification->id }}')"
                                               class="inline-flex items-center px-3 py-2 text-xs font-medium text-green-700 bg-green-100 rounded-lg hover:bg-green-200 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Mark Read
                                        </button>
                                    @endif

                                    <button wire:click="deleteNotification('{{ $notification->id }}')"
                                           wire:confirm="Are you sure you want to delete this notification?"
                                           class="inline-flex items-center px-3 py-2 text-xs font-medium text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM9 17h5l-5 5v-5z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500 dark:text-gray-700">No notifications found matching your criteria.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            @if($this->notifications->hasPages())
                <div class="px-6 py-4 border-t border-gray-200/60">
                    {{ $this->notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
