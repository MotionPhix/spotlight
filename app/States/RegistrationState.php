<?php

namespace App\States;

use App\Events\UserRegistered;
use App\Events\PhoneVerified;
use App\Events\PaymentCompleted;
use App\Mail\RegistrationNotification;
use App\Mail\PaymentCompletedNotification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Thunk\Verbs\State;

class RegistrationState extends State
{
    public int $userId;
    public string $firstName;
    public string $lastName;
    public ?string $email;
    public string $phone;
    public bool $phoneVerified = false;
    public array $interests = [];
    public string $location;
    public array $currentKnowledge = [];
    public string $status = 'pending';
    public float $amountPaid = 0;
    public ?string $paymentReference = null;

    public function applyUserRegistered(UserRegistered $event): void
    {
        $this->userId = $event->userId;
        $this->firstName = $event->firstName;
        $this->lastName = $event->lastName;
        $this->email = $event->email;
        $this->phone = $event->phone;
        $this->interests = $event->interests;
        $this->location = $event->location;
        $this->currentKnowledge = $event->currentKnowledge;
        $this->status = 'pending';
        
        // Send registration notification email to admin
        $user = User::find($this->userId);
        if ($user && config('mail.admin_email')) {
            Mail::send(new RegistrationNotification($user));
        }
    }

    public function applyPhoneVerified(PhoneVerified $event): void
    {
        $this->phoneVerified = true;
        $this->status = 'approved';
        
        // Update the user model
        User::find($this->userId)->update([
            'phone_verified_at' => now(),
            'registration_status' => 'approved',
        ]);
    }

    public function applyPaymentCompleted(PaymentCompleted $event): void
    {
        $this->amountPaid = $event->amount;
        $this->paymentReference = $event->paymentReference;
        $this->status = 'completed';
        
        // Update the user model
        $user = User::find($this->userId);
        $user->update([
            'amount_paid' => $event->amount,
            'payment_reference' => $event->paymentReference,
            'registration_status' => 'completed',
            'registered_at' => now(),
        ]);
        
        // Send payment completion notification email to admin
        \Log::info('About to send payment completion email', [
            'user_id' => $user->id,
            'admin_email' => config('mail.admin_email'),
            'amount' => $event->amount,
            'payment_ref' => $event->paymentReference
        ]);
        
        if (config('mail.admin_email')) {
            try {
                Mail::send(new PaymentCompletedNotification(
                    $user,
                    $event->amount,
                    $event->paymentReference
                ));
                \Log::info('Payment completion email sent successfully');
            } catch (\Exception $e) {
                \Log::error('Failed to send payment completion email: ' . $e->getMessage());
            }
        } else {
            \Log::warning('No admin email configured - email not sent');
        }
    }

    public function isEligibleForPayment(): bool
    {
        return $this->phoneVerified && $this->status === 'approved';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed' && $this->amountPaid >= 7000;
    }

    public function hasRegistrationFee(): bool
    {
        return $this->amountPaid >= 7000;
    }
}