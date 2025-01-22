<?php

namespace Database\Factories;

use App\Enums\Platform;
use App\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ApplicationCredentials>
 */
class ApplicationCredentialsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'application_id' => Application::factory(),
            'platform' => collect(Platform::cases())->pluck('value')->random(),
            'username' => fake()->userName(),
            'password' => fake()->password(),
        ];
    }
}
