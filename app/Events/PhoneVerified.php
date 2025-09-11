<?php

namespace App\Events;

use App\States\RegistrationState;
use Thunk\Verbs\Attributes\StateId;
use Thunk\Verbs\Event;

class PhoneVerified extends Event
{
    public function __construct(
        #[StateId(RegistrationState::class)]
        public int $userId,
        public string $phone,
    ) {
    }
}