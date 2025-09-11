<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            to: config('mail.admin_email', 'admin@example.com'),
            subject: 'New Artisan Training Registration - ' . $this->user->fullName(),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.registration-notification',
        );
    }
}