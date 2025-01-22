<?php

namespace Database\Factories;

use App\Enums\Platform;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class DeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uid' => fake()->uuid(),
            'platform' => collect(Platform::cases())->pluck('value')->random(),
            'language' => fake()->languageCode(),
        ];
    }
}
