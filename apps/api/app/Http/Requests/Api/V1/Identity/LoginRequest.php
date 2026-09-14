<?php

namespace App\Http\Requests\Api\V1\Identity;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'lowercase', 'max:254', 'email:rfc'],
            'password' => ['required', 'string', 'max:72'],
        ];
    }

    /** @return array{email: string, password: string} */
    public function credentials(): array
    {
        return $this->safe()->only(['email', 'password']);
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('email')) {
            $this->merge([
                'email' => Str::lower($this->string('email')->trim()->toString()),
            ]);
        }
    }
}
