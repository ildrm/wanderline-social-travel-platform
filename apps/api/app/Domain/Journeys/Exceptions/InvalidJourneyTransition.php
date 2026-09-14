<?php

namespace App\Domain\Journeys\Exceptions;

use App\Domain\Journeys\Enums\JourneyStatus;
use Exception;
use Illuminate\Contracts\Debug\ShouldntReport;

class InvalidJourneyTransition extends Exception implements ShouldntReport
{
    public function __construct(
        public readonly JourneyStatus $from,
        public readonly JourneyStatus $to,
    ) {
        parent::__construct("A journey cannot transition from {$from->value} to {$to->value}.");
    }

    /** @return array{from_status: string, to_status: string} */
    public function context(): array
    {
        return [
            'from_status' => $this->from->value,
            'to_status' => $this->to->value,
        ];
    }
}
