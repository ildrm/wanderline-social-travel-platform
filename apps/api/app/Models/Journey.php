<?php

namespace App\Models;

use App\Domain\Journeys\Enums\JourneyMode;
use App\Domain\Journeys\Enums\JourneyStatus;
use App\Domain\Journeys\Enums\JourneyVisibility;
use Database\Factories\JourneyFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property int $owner_id
 * @property JourneyMode $mode
 * @property string $title
 * @property JourneyStatus $status
 * @property int $capacity
 * @property JourneyVisibility $visibility
 * @property string $timezone
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['mode', 'title', 'capacity', 'visibility', 'timezone'])]
class Journey extends Model
{
    /** @use HasFactory<JourneyFactory> */
    use HasFactory;

    use HasUlids;

    protected $attributes = [
        'status' => JourneyStatus::Draft->value,
        'visibility' => JourneyVisibility::Private->value,
    ];

    /** @return BelongsTo<User, $this> */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /** @return HasMany<JourneyTransition, $this> */
    public function transitionHistory(): HasMany
    {
        return $this->hasMany(JourneyTransition::class)
            ->orderByDesc('transitioned_at')
            ->orderByDesc('id');
    }

    /** @return HasMany<JourneyDay, $this> */
    public function days(): HasMany
    {
        return $this->hasMany(JourneyDay::class)
            ->orderBy('position');
    }

    /** @return HasMany<Location, $this> */
    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    /** @return HasMany<TransportationLeg, $this> */
    public function transportationLegs(): HasMany
    {
        return $this->hasMany(TransportationLeg::class)
            ->orderBy('position');
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'mode' => JourneyMode::class,
            'status' => JourneyStatus::class,
            'visibility' => JourneyVisibility::class,
            'capacity' => 'integer',
        ];
    }
}
