<?php

use App\Models\User;
use App\Events\UserRegistered;
use App\States\RegistrationState;
use App\Mail\RegistrationNotification;
use App\Notifications\RegistrationReceived;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Propaganistas\LaravelPhone\PhoneNumber;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $phone = '';
    public array $interests = [];
    public string $location = '';
    public array $current_knowledge = [];
    public bool $terms_accepted = false;

    public array $interest_options = [
        'graphic_design' => 'Graphic Design',
        'large_format_printing' => 'Large Format Printing',
        'embroidery_digitization' => 'Embroidery & Digitization',
        'screen_printing' => 'Screen Printing',
        'signage_branding' => 'Signage & Branding',
        'machine_troubleshooting' => 'Machine Troubleshooting',
    ];

    public array $knowledge_options = [
        'computer_basic' => 'Basic computer skills',
        'computer_intermediate' => 'Intermediate computer skills',
        'computer_advanced' => 'Advanced computer skills',
        'printing_experience' => 'Previous printing experience',
        'design_experience' => 'Design experience',
        'business_experience' => 'Business/entrepreneurship experience',
        'none' => 'No prior experience',
    ];

    public array $malawi_districts = [
        'Lilongwe', 'Blantyre', 'Mzuzu', 'Zomba', 'Kasungu', 'Mangochi',
        'Salima', 'Machinga', 'Balaka', 'Dedza', 'Dowa', 'Ntcheu',
        'Ntchisi', 'Nkhotakota', 'Mchinji', 'Chiradzulu', 'Nsanje',
        'Chikwawa', 'Thyolo', 'Mulanje', 'Phalombe', 'Chikhwawa',
        'Neno', 'Mwanza', 'Chitipa', 'Karonga', 'Rumphi', 'Nkhata Bay',
        'Likoma'
    ];

    /**
     * Handle registration for the artisan training program.
     */
    public function register(): void
    {
        $this->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'phone:MW', 'unique:' . User::class],
            'interests' => ['required', 'array', 'min:1'],
            'interests.*' => ['string', 'in:' . implode(',', array_keys($this->interest_options))],
            'location' => ['required', 'string', 'in:' . implode(',', $this->malawi_districts)],
            'current_knowledge' => ['required', 'array', 'min:1'],
            'current_knowledge.*' => ['string', 'in:' . implode(',', array_keys($this->knowledge_options))],
            'terms_accepted' => ['accepted'],
        ], [
            'phone.phone' => 'Please enter a valid Malawi phone number (e.g., +265 123 456 789)',
            'phone.unique' => 'This phone number is already registered.',
            'interests.required' => 'Please select at least one area of interest.',
            'interests.min' => 'Please select at least one area of interest.',
            'current_knowledge.required' => 'Please select your current knowledge level.',
            'current_knowledge.min' => 'Please select at least one knowledge area.',
            'location.in' => 'Please select a valid district in Malawi.',
            'terms_accepted.accepted' => 'You must agree to the terms and conditions.',
        ]);

        // Format phone number
        $phoneNumber = new PhoneNumber($this->phone, 'MW');

        $user = User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email ?: null,
            'phone' => $phoneNumber->formatE164(),
            'interests' => $this->interests,
            'location' => $this->location,
            'current_knowledge' => $this->current_knowledge,
            'registration_status' => 'pending',
            'password' => Hash::make('temporary_' . time()), // Temporary password, not used for login
        ]);

        // Fire event for event sourcing
        UserRegistered::fire(
            userId: $user->id,
            firstName: $this->first_name,
            lastName: $this->last_name,
            email: $this->email,
            phone: $phoneNumber->formatE164(),
            interests: $this->interests,
            location: $this->location,
            currentKnowledge: $this->current_knowledge,
        );

        // Send notification to user
        $user->notify(new RegistrationReceived());

        // Send comprehensive registration confirmation email to user (if email provided)
        if ($user->email) {
            Mail::send(new \App\Mail\UserRegistrationConfirmation($user));
        }

        // Send email notification to admin
        Mail::send(new RegistrationNotification($user));

        session()->flash('registration_success', 'Application submitted successfully! You will be contacted within 24 hours.');

        // Redirect to checkout page
        session()->put('registered_user_id', $user->id);
        $this->redirect(route('checkout'), navigate: true);
    }
}; ?>

<div class="space-y-6 w-full min-w-0">
    <x-auth-header
        title="Register for Artisan Skills Training"
        description="Complete your application for our 6-month program"
    />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    @if(session('registration_success'))
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-green-700 dark:text-green-300 font-medium">{{ session('registration_success') }}</p>
            </div>
        </div>
    @endif

    <form method="POST" wire:submit="register" class="space-y-6 w-full min-w-0">
        <!-- Personal Information -->
        <div class="border-b border-zinc-200 dark:border-zinc-700 pb-6">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Personal Information</h3>

            <div class="grid sm:grid-cols-2 gap-4 mb-4 min-w-0">
                <!-- First Name -->
                <x-bladewind::input
                    wire:model="first_name"
                    label="First Name"
                    type="text"
                    required
                    autofocus
                    placeholder="Your first name"
                />

                <!-- Last Name -->
                <x-bladewind::input
                    wire:model="last_name"
                    label="Last Name"
                    type="text"
                    required
                    placeholder="Your last name"
                />
            </div>

            <div class="space-y-4">
                <!-- Email Address -->
                <x-bladewind::input
                    wire:model="email"
                    label="Email Address (Optional)"
                    type="email"
                    autocomplete="email"
                    placeholder="email@example.com"
                    description="Email is optional but recommended for updates"
                />

                <!-- Phone Number -->
                <x-bladewind::input
                    wire:model="phone"
                    label="Phone Number (Required)"
                    type="tel"
                    required
                    placeholder="+265 123 456 789"
                    description="Valid Malawi phone number required for verification"
                />
            </div>
        </div>

        <!-- Location -->
        <div class="border-b border-zinc-200 dark:border-zinc-700 pb-6">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Location</h3>

            <div>
                <label class="block text-sm font-medium text-zinc-900 dark:text-zinc-100 mb-2">
                    District in Malawi <span class="text-red-500">*</span>
                </label>
                <select
                    wire:model="location"
                    required
                    class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:text-zinc-100"
                >
                    <option value="">Select your district</option>
                    @foreach($malawi_districts as $district)
                        <option value="{{ $district }}">{{ $district }}</option>
                    @endforeach
                </select>
                @error('location')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Interests -->
        <div class="border-b border-zinc-200 dark:border-zinc-700 pb-6">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Areas of Interest</h3>
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4">Select the skills you want to learn (choose at least one):</p>

            <div class="grid sm:grid-cols-2 gap-3 min-w-0">
                @foreach($interest_options as $key => $label)
                    <label class="flex items-center space-x-3 p-3 border border-zinc-200 dark:border-zinc-700 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 cursor-pointer min-w-0">
                        <input
                            type="checkbox"
                            wire:model="interests"
                            value="{{ $key }}"
                            class="w-4 h-4 text-blue-600 bg-zinc-100 border-zinc-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-zinc-800 focus:ring-2 dark:bg-zinc-700 dark:border-zinc-600 flex-shrink-0"
                        >
                        <span class="text-sm font-medium text-zinc-900 dark:text-zinc-100 break-words">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
            @error('interests')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Current Knowledge -->
        <div class="border-b border-zinc-200 dark:border-zinc-700 pb-6">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Current Knowledge</h3>
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4">Tell us about your current skills and experience:</p>

            <div class="space-y-3">
                @foreach($knowledge_options as $key => $label)
                    <label class="flex items-center space-x-3 p-3 border border-zinc-200 dark:border-zinc-700 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 cursor-pointer min-w-0">
                        <input
                            type="checkbox"
                            wire:model="current_knowledge"
                            value="{{ $key }}"
                            class="w-4 h-4 text-blue-600 bg-zinc-100 border-zinc-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-zinc-800 focus:ring-2 dark:bg-zinc-700 dark:border-zinc-600 flex-shrink-0"
                        >
                        <span class="text-sm font-medium text-zinc-900 dark:text-zinc-100 break-words">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
            @error('current_knowledge')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Payment Information -->
        <div class="border-b border-zinc-200 dark:border-zinc-700 pb-6">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Payment Information</h3>

            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-4 mb-4">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="text-sm text-blue-800 dark:text-blue-200">
                        <p class="font-semibold mb-2">Registration Process & Payment Structure</p>
                        <div class="space-y-2">
                            <p><strong>Registration Fee:</strong> MWK 7,000 (non-refundable)</p>
                            <p class="text-xs">This initial fee secures your application and covers administrative processing costs.</p>

                            <p><strong>Program Fee:</strong> MWK 300,000 (total consultancy fee)</p>
                            <p class="text-xs">The full program fee will be discussed and processed after your application is reviewed and you are contacted within 24 hours of registration.</p>

                            <p class="pt-2 font-medium">You are only paying the registration fee (MWK 7,000) at this time.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Terms and Conditions -->
        <div class="pb-6">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Agreement & Terms</h3>

            <div class="bg-zinc-50 dark:bg-zinc-800 rounded-lg p-4">
                <label class="flex items-start space-x-3 cursor-pointer">
                    <input
                        type="checkbox"
                        wire:model="terms_accepted"
                        required
                        class="w-4 h-4 text-blue-600 bg-zinc-100 border-zinc-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-zinc-800 focus:ring-2 dark:bg-zinc-700 dark:border-zinc-600 mt-1"
                    >
                    <div class="text-sm text-zinc-700 dark:text-zinc-300">
                        <p class="font-medium mb-2">I acknowledge and agree to the following:</p>
                        <ul class="space-y-1 text-xs list-disc list-inside">
                            <li>I understand this is a 6-month professional artisan skills training program by Spotlight Consultancy</li>
                            <li>The registration fee of MWK 7,000 is non-refundable and secures my application for review</li>
                            <li>The total program fee of MWK 300,000 will be discussed after application review</li>
                            <li>I agree to attend classes regularly and follow all program guidelines upon acceptance</li>
                            <li>I consent to being contacted by Spotlight Consultancy within 24 hours regarding my application status</li>
                            <li>I understand that program acceptance is subject to application review and available capacity</li>
                        </ul>
                    </div>
                </label>
                @error('terms_accepted')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Program Information -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-3">Program Summary</h3>
            <div class="grid sm:grid-cols-2 gap-4 text-sm text-blue-800 dark:text-blue-200 min-w-0">
                <div>
                    <p><strong>Duration:</strong> 6 months</p>
                    <p><strong>Registration Fee:</strong> MWK 7,000</p>
                    <p><strong>Total Program Fee:</strong> MWK 300,000</p>
                </div>
                <div>
                    <p><strong>Location:</strong> Area 45, Chinsapo, Lilongwe</p>
                    <p><strong>Contact:</strong> Within 24 hours after registration</p>
                    <p><strong>Provider:</strong> Spotlight Consultancy</p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end">
            <x-bladewind::button type="submit" class="w-full" uppercasing="false">
                Register & Continue to Payment
            </x-bladewind::button>
        </div>
    </form>

    <div class="text-center text-sm text-zinc-600 dark:text-zinc-400">
        <p>By submitting this application, you will be redirected to secure payment processing via PayChangu.</p>
    </div>
</div>
