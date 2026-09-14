<?php

namespace App\Events;

use App\Models\Journey;
use App\Models\JourneyTransition;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JourneyStatusTransitioned implements ShouldDispatchAfterCommit
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly Journey $journey,
        public readonly JourneyTransition $transition,
    ) {}
}
