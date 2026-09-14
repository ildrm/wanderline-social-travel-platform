<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $id
 * @property string $journey_id
 * @property string $name
 * @property string $country_code
 * @property string $timezone
 * @property float $public_latitude
 * @property float $public_longitude
 */
#[Fillable(['name', 'country_code', 'timezone', 'public_latitude', 'public_longitude'])]
#[Hidden(['restricted_exact_coordinates', 'restricted_exact_latitude', 'restricted_exact_longitude'])]
class Location extends Model
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
        return $this->hasMany(Stop::class);
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'public_latitude' => 'float',
            'public_longitude' => 'float',
        ];
    }
}
