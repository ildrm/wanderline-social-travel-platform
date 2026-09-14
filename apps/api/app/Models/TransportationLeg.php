<?php

namespace App\Models;

use App\Domain\Journeys\Enums\TransportationMode;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $journey_id
 * @property string $origin_stop_id
 * @property string $destination_stop_id
 * @property int $position
 * @property TransportationMode $mode
 * @property string|null $provider
 * @property Carbon $departure_at
 * @property Carbon $arrival_at
 */
#[Fillable(['origin_stop_id', 'destination_stop_id', 'position', 'mode', 'provider', 'departure_at', 'arrival_at'])]
class TransportationLeg extends Model
{
    use HasUlids;

    /** @return BelongsTo<Journey, $this> */
    public function journey(): BelongsTo
    {
        return $this->belongsTo(Journey::class);
    }

    /** @return BelongsTo<Stop, $this> */
    public function originStop(): BelongsTo
    {
        return $this->belongsTo(Stop::class, 'origin_stop_id');
    }

    /** @return BelongsTo<Stop, $this> */
    public function destinationStop(): BelongsTo
    {
        return $this->belongsTo(Stop::class, 'destination_stop_id');
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'position' => 'integer',
            'mode' => TransportationMode::class,
            'departure_at' => 'immutable_datetime',
            'arrival_at' => 'immutable_datetime',
        ];
    }
}
