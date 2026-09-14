<?php

namespace App\Domain\Journeys\Enums;

enum TransportationMode: string
{
    case Air = 'AIR';
    case Rail = 'RAIL';
    case Road = 'ROAD';
    case Sea = 'SEA';
    case Walk = 'WALK';
}
