<?php

use App\Models\Communication;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

new #[Layout('components.layouts.admin')] class extends Component {
    use WithPagination, WithFileUploads;

    public $type = 'email';
    public $recipient_type = 'all';
    public $recipients = [];
    public $subject = '';
    public $message = '';
    public $showForm = false;
    public $selectedStatuses = [];
    public $selectedUsers = [];
    public $attachments = [];

    public function showComposeForm()
    {
        $this->showForm = true;
        $this->reset(['type', 'recipient_type', 'recipients', 'subject', 'message', 'selectedStatuses', 'selectedUsers', 'attachments']);
        $this->type = 'email';
        $this->recipient_type = 'all';
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->reset(['type', 'recipient_type', 'recipients', 'subject', 'message', 'selectedStatuses', 'selectedUsers', 'attachments']);
    }

    public function removeAttachment($index)
    {
        unset($this->attachments[$index]);
        $this->attachments = array_values($this->attachments);
    }

    public function updatedRecipientType()
    {
        $this->reset(['selectedStatuses', 'selectedUsers']);
    }

    public function sendCommunication()
    {
        $this->validate([
            'type' => 'required|in:email,notification',
            'recipient_type' => 'required|in:all,status,individual',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'selectedStatuses' => 'required_if:recipient_type,status',
            'selectedUsers' => 'required_if:recipient_type,individual',
            'attachments.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif,txt,zip',
        ]);

        $recipients = match ($this->recipient_type) {
            'status' => $this->selectedStatuses,
            'individual' => $this->selectedUsers,
            default => null,
        };

        $communication = Communication::create([
            'sent_by' => auth()->id(),
            'type' => $this->type,
            'recipient_type' => $this->recipient_type,
            'recipients' => $recipients,
            'subject' => $this->subject,
            'message' => $this->message,
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        // Handle file attachments
        if (!empty($this->attachments)) {
            foreach ($this->attachments as $attachment) {
                if ($attachment) {
                    $communication->addMedia($attachment->getRealPath())
                        ->usingName($attachment->getClientOriginalName())
                        ->usingFileName($attachment->getClientOriginalName())
                        ->toMediaCollection('attachments');
                }
            }
        }

        // Get users to send to
        $users = $this->getRecipientUsers();

        if ($this->type === 'email') {
            $this->sendEmails($users, $communication);
        } else {
            $this->sendNotifications($users, $communication);
        }

        $communication->update([
            'sent_count' => $users->count(),
        ]);

        session()->flash('message', 'Communication sent successfully to ' . $users->count() . ' users!');
        $this->closeForm();
    }

    private function getRecipientUsers()
    {
        return match ($this->recipient_type) {
            'all' => User::where('is_admin', false)->get(),
            'status' => User::where('is_admin', false)->whereIn('registration_status', $this->selectedStatuses)->get(),
            'individual' => User::where('is_admin', false)->whereIn('id', $this->selectedUsers)->get(),
            default => collect(),
        };
    }

    private function sendEmails($users, $communication)
    {
        foreach ($users as $user) {
            try {
                Mail::raw($this->message, function ($message) use ($user) {
                    $message->to($user->email)
                           ->subject($this->subject);
                });
            } catch (\Exception $e) {
                \Log::error('Failed to send email to ' . $user->email . ': ' . $e->getMessage());
            }
        }
    }

    private function sendNotifications($users, $communication)
    {
        foreach ($users as $user) {
            try {
                $user->notifications()->create([
                    'id' => \Str::uuid(),
                    'type' => 'App\\Notifications\\AdminMessage',
                    'data' => [
                        'subject' => $this->subject,
                        'message' => $this->message,
                        'communication_id' => $communication->id,
                    ],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to create notification for user ' . $user->id . ': ' . $e->getMessage());
            }
        }
    }

    public function getCommunicationsProperty()
    {
        return Communication::with('sentBy')
            ->latest()
            ->paginate(10);
    }

    public function getAvailableUsersProperty()
    {
        return User::where('is_admin', false)
            ->select('id', 'first_name', 'last_name', 'email')
            ->get();
    }

    public function getRecipientCountProperty()
    {
        return match ($this->recipient_type) {
            'all' => User::where('is_admin', false)->count(),
            'status' => empty($this->selectedStatuses) ? 0 : User::where('is_admin', false)->whereIn('registration_status', $this->selectedStatuses)->count(),
            'individual' => count($this->selectedUsers),
            default => 0,
        };
    }
}; ?>
<div>
    <div class="space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl shadow-lg mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent dark:from-gray-900 dark:to-gray-600">Communications</h1>
            <p class="text-lg text-gray-600 dark:text-gray-700 mt-2">Send messages and notifications to users</p>

            <div class="mt-6">
                <button wire:click="showComposeForm"
                        class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Compose Message
                </button>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('message') }}
                </div>
            </div>
        @endif

        <!-- Communications History -->
        <div class="bg-white/70 dark:bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-200/60 overflow-hidden">

            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-6 h-6 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-900">Communication History</h3>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-600">{{ $this->communications->total() }} total communications</div>
                </div>

                <div class="space-y-4">
                    @forelse ($this->communications as $communication)
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-50 dark:to-white rounded-xl p-6 border border-gray-200/60 hover:shadow-lg hover:scale-[1.01] transition-all duration-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <!-- Header -->
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                {{ $communication->type === 'email' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                {{ ucfirst($communication->type) }}
                                            </div>
                                            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                {{ match($communication->status) {
                                                    'sent' => 'bg-emerald-100 text-emerald-800',
                                                    'sending' => 'bg-amber-100 text-amber-800',
                                                    'failed' => 'bg-red-100 text-red-800',
                                                    default => 'bg-gray-100 text-gray-800'
                                                } }}">
                                                {{ ucfirst($communication->status) }}
                                            </div>
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-600">
                                            {{ $communication->sent_at?->format('M j, Y g:i A') }}
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="mb-3">
                                        <h4 class="font-semibold text-gray-900 dark:text-gray-900 mb-1">{{ $communication->subject }}</h4>
                                        <p class="text-gray-600 dark:text-gray-700 text-sm">{{ Str::limit($communication->message, 150) }}</p>
                                    </div>

                                    <!-- Recipients Info -->
                                    <div class="flex items-center justify-between text-sm">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex items-center text-gray-600">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                {{ $communication->sent_count }} recipients
                                            </div>
                                            <div class="text-gray-500">
                                                {{ ucfirst(str_replace('_', ' ', $communication->recipient_type)) }}
                                            </div>
                                        </div>
                                        <div class="text-gray-600">
                                            by {{ $communication->sentBy->fullName() }}
                                        </div>
                                    </div>

                                    <!-- Attachments -->
                                    @if($communication->hasMedia('attachments'))
                                        <div class="mt-3 pt-3 border-t border-gray-200">
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                                </svg>
                                                {{ $communication->getMedia('attachments')->count() }} attachment(s)
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500 dark:text-gray-700">No communications sent yet. Click "Compose Message" to get started!</p>
                        </div>
                    @endforelse
                </div>
            </div>


            @if($this->communications->hasPages())
                <div class="px-6 py-4 border-t border-gray-200/60">
                    {{ $this->communications->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Compose Message Modal -->
    @if($showForm)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
                     wire:click="closeForm"></div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal panel -->
                <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom bg-white/90 backdrop-blur-sm rounded-2xl shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full sm:p-6 border border-gray-200/60">

                    <!-- Modal header -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Compose Message</h3>
                        </div>
                        <button wire:click="closeForm" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal content -->
                    <div class="space-y-6">
                        <!-- Communication Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Communication Type</label>
                            <select wire:model.live="type" class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="email">Email</option>
                                <option value="notification">In-App Notification</option>
                            </select>
                        </div>

                        <!-- Send To -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Send To</label>
                            <select wire:model.live="recipient_type" class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="all">All Users</option>
                                <option value="status">Users by Status</option>
                                <option value="individual">Specific Users</option>
                            </select>
                        </div>

                        <!-- Status Selection -->
                        @if($recipient_type === 'status')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Registration Status</label>
                                <div class="space-y-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" wire:model.live="selectedStatuses" value="pending" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Pending</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" wire:model.live="selectedStatuses" value="approved" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Approved</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" wire:model.live="selectedStatuses" value="payment_pending" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Payment Pending</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" wire:model.live="selectedStatuses" value="completed" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Completed</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" wire:model.live="selectedStatuses" value="rejected" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Rejected</span>
                                    </label>
                                </div>
                            </div>
                        @endif

                        <!-- Individual User Selection -->
                        @if($recipient_type === 'individual')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Select Users</label>
                                <div class="max-h-40 overflow-y-auto space-y-2 border border-gray-200 rounded-xl p-4 bg-gray-50">
                                    @foreach($this->availableUsers as $user)
                                        <label class="flex items-center">
                                            <input type="checkbox" wire:model.live="selectedUsers" value="{{ $user->id }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                            <span class="ml-2 text-sm text-gray-700">{{ $user->fullName() }} ({{ $user->email }})</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Subject -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                            <input type="text" wire:model="subject" placeholder="Enter subject..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            @error('subject') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Message -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea wire:model="message" placeholder="Enter your message..." rows="6"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none"></textarea>
                            @error('message') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- File Attachments -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Attachments</label>
                            <div class="space-y-3">
                                <!-- File Upload Area -->
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-indigo-400 transition-colors">
                                    <input type="file" wire:model="attachments" multiple
                                           class="hidden" id="file-upload">
                                    <label for="file-upload" class="cursor-pointer">
                                        <div class="space-y-2">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <div class="text-sm text-gray-600">
                                                <span class="font-medium text-indigo-600 hover:text-indigo-500">Click to upload</span>
                                                or drag and drop
                                            </div>
                                            <p class="text-xs text-gray-500">PDF, DOC, XLS, PPT, Images up to 10MB each</p>
                                        </div>
                                    </label>
                                </div>

                                <!-- Loading indicator -->
                                <div wire:loading wire:target="attachments" class="text-center">
                                    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Uploading files...
                                    </div>
                                </div>

                                <!-- Uploaded Files List -->
                                @if(!empty($attachments))
                                    <div class="space-y-2">
                                        @foreach($attachments as $index => $attachment)
                                            @if($attachment)
                                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="flex-shrink-0">
                                                            @php
                                                                $extension = strtolower(pathinfo($attachment->getClientOriginalName(), PATHINFO_EXTENSION));
                                                                $iconClass = match($extension) {
                                                                    'pdf' => 'text-red-600',
                                                                    'doc', 'docx' => 'text-blue-600',
                                                                    'xls', 'xlsx' => 'text-green-600',
                                                                    'ppt', 'pptx' => 'text-orange-600',
                                                                    'jpg', 'jpeg', 'png', 'gif' => 'text-purple-600',
                                                                    default => 'text-gray-600'
                                                                };
                                                            @endphp
                                                            <svg class="h-6 w-6 {{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                            </svg>
                                                        </div>
                                                        <div class="min-w-0 flex-1">
                                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                                {{ $attachment->getClientOriginalName() }}
                                                            </p>
                                                            <p class="text-xs text-gray-500">
                                                                {{ number_format($attachment->getSize() / 1024, 1) }} KB
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <button wire:click="removeAttachment({{ $index }})" type="button"
                                                            class="ml-3 text-gray-400 hover:text-red-600 transition-colors">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif

                                <!-- File validation errors -->
                                @error('attachments.*')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Recipients Preview -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-xl border border-blue-200">
                            <div class="text-sm text-gray-700 space-y-2">
                                <div>
                                    <span class="font-medium">This will be sent to:</span>
                                    @if($recipient_type === 'all')
                                        <span class="text-green-700 font-semibold">All {{ $this->recipientCount }} users</span>
                                    @elseif($recipient_type === 'status')
                                        @if($this->recipientCount > 0)
                                            <span class="text-green-700 font-semibold">{{ $this->recipientCount }} users with selected statuses</span>
                                        @else
                                            <span class="text-amber-700">No status selected ({{ count($selectedStatuses) }} statuses checked)</span>
                                        @endif
                                    @elseif($recipient_type === 'individual')
                                        @if($this->recipientCount > 0)
                                            <span class="text-green-700 font-semibold">{{ $this->recipientCount }} selected users</span>
                                        @else
                                            <span class="text-amber-700">No users selected ({{ count($selectedUsers) }} users checked)</span>
                                        @endif
                                    @else
                                        <span class="text-amber-700">No recipients selected</span>
                                    @endif
                                </div>
                                @if(!empty($attachments))
                                    <div class="flex items-center space-x-2 text-xs">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                        </svg>
                                        <span>{{ count(array_filter($attachments)) }} attachment(s) will be included</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="flex items-center justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                        <button wire:click="closeForm" type="button"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                            Cancel
                        </button>
                        <button wire:click="sendCommunication" type="button"
                                class="px-6 py-2 text-sm font-medium text-white bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105">
                            <span wire:loading.remove wire:target="sendCommunication">Send {{ ucfirst($type) }}</span>
                            <span wire:loading wire:target="sendCommunication" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Sending...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
