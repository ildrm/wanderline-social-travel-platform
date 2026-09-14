<?php

namespace App\Http\Requests\Api\V1\Journeys;

use App\Domain\Journeys\Enums\JourneyMode;
use App\Domain\Journeys\Enums\JourneyVisibility;
use App\Models\Journey;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJourneyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('create', Journey::class) ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mode' => ['required', Rule::enum(JourneyMode::class)],
            'title' => ['required', 'string', 'min:3', 'max:160'],
            'capacity' => ['required', 'integer', 'between:1,100000'],
            'visibility' => ['required', Rule::enum(JourneyVisibility::class)],
            'timezone' => ['required', 'string', 'timezone:all'],
            'id' => ['prohibited'],
            'owner_id' => ['prohibited'],
            'status' => ['prohibited'],
        ];
    }
}
