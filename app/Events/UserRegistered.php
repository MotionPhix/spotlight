<?php

namespace App\Events;

use App\States\RegistrationState;
use Thunk\Verbs\Attributes\StateId;
use Thunk\Verbs\Event;

class UserRegistered extends Event
{
    public function __construct(
        #[StateId(RegistrationState::class)]
        public int $userId,
        public string $firstName,
        public string $lastName,
        public ?string $email,
        public string $phone,
        public array $interests,
        public string $location,
        public array $currentKnowledge,
    ) {
    }
}