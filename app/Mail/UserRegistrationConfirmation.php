<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserRegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            to: $this->user->email ?: null,
            subject: 'Registration Confirmed - Spotlight Consultancy Artisan Training Program',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.user-registration-confirmation',
        );
    }
}