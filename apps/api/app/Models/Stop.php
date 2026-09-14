<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $journey_day_id
 * @property string $location_id
 * @property int $position
 * @property string|null $label
 * @property Carbon|null $arrival_at
 * @property Carbon|null $departure_at
 */
#[Fillable(['location_id', 'position', 'label', 'arrival_at', 'departure_at'])]
class Stop extends Model
{
    use HasUlids;

    /** @return BelongsTo<JourneyDay, $this> */
    public function day(): BelongsTo
    {
        return $this->belongsTo(JourneyDay::class, 'journey_day_id');
    }

    /** @return BelongsTo<Location, $this> */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /** @return HasMany<Activity, $this> */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class)
            ->orderBy('position');
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'position' => 'integer',
            'arrival_at' => 'immutable_datetime',
            'departure_at' => 'immutable_datetime',
        ];
    }
}
