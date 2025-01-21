<?php

namespace App\Http\Requests\Device;

use App\Enums\Platform;
use App\Models\Application;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class RegisterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'uid' => ['required', 'string', 'max:64'],
            'app_id' => ['required', 'exists:'.Application::class.',id'],
            'os' => ['required', 'string', new Enum(Platform::class)],
            'language' => ['required', 'string', 'max:5'],
        ];
    }

    public function passedValidation(): void
    {
        $this->merge([
            'platform' => $this->os,
        ]);
    }
}
