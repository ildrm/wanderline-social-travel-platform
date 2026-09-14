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
 * @property string $journey_id
 * @property int $position
 * @property Carbon $calendar_date
 * @property string $timezone
 */
#[Fillable(['position', 'calendar_date', 'timezone'])]
class JourneyDay extends Model
{
    use HasUlids;

    /** @return BelongsTo<Journey, $this> */
    public function journey(): BelongsTo
    {
        return $this->belongsTo(Journey::class);
    }

    /** @return HasMany<Stop, $this> */
    public function stops(): HasMany
    {
        return $this->hasMany(Stop::class)
            ->orderBy('position');
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'position' => 'integer',
            'calendar_date' => 'date',
        ];
    }
}
