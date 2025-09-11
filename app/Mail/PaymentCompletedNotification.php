<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentCompletedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public float $amount,
        public string $paymentReference
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            to: config('mail.admin_email', 'admin@example.com'),
            subject: 'Payment Completed - ' . $this->user->fullName() . ' - MWK ' . number_format($this->amount),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-completed-notification',
        );
    }
}