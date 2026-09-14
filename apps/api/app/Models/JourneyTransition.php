<?php

namespace App\Models;

use App\Domain\Journeys\Enums\JourneyStatus;
use Carbon\CarbonImmutable;
use Database\Factories\JourneyTransitionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $journey_id
 * @property JourneyStatus $from_status
 * @property JourneyStatus $to_status
 * @property int $actor_id
 * @property string|null $note
 * @property CarbonImmutable $transitioned_at
 */
#[Fillable(['from_status', 'to_status', 'actor_id', 'note', 'transitioned_at'])]
class JourneyTransition extends Model
{
    /** @use HasFactory<JourneyTransitionFactory> */
    use HasFactory;

    use HasUlids;

    public $timestamps = false;

    /** @return BelongsTo<Journey, $this> */
    public function journey(): BelongsTo
    {
        return $this->belongsTo(Journey::class);
    }

    /** @return BelongsTo<User, $this> */
    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'from_status' => JourneyStatus::class,
            'to_status' => JourneyStatus::class,
            'transitioned_at' => 'immutable_datetime',
        ];
    }
}
