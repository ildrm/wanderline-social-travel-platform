<?php

namespace App\Domain\Journeys\Enums;

enum JourneyVisibility: string
{
    case Private = 'PRIVATE';
    case Unlisted = 'UNLISTED';
    case Public = 'PUBLIC';
}
