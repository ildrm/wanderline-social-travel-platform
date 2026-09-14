<?php

namespace App\Domain\Journeys\Enums;

enum JourneyMode: string
{
    case Social = 'SOCIAL';
    case Experience = 'EXPERIENCE';
    case Professional = 'PROFESSIONAL';
    case PrivateGroup = 'PRIVATE_GROUP';
}
