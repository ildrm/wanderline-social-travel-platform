<?php

namespace App\Http\Requests\Api\V1\Journeys;

use App\Domain\Journeys\Enums\JourneyStatus;
use App\Models\Journey;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransitionJourneyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $journey = $this->route('journey');

        return $journey instanceof Journey
            && ($this->user()?->can('transition', $journey) ?? false);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::enum(JourneyStatus::class)],
            'note' => ['sometimes', 'nullable', 'string', 'max:1000'],
        ];
    }

    public function targetStatus(): JourneyStatus
    {
        return JourneyStatus::from($this->string('status')->toString());
    }
}
