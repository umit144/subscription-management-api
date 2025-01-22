<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'device_id' => Device::factory(),
            'application_id' => Application::factory(),
            'receipt' => fake()->uuid(),
            'status' => fake()->boolean(),
            'expire_date' => fake()->dateTimeBetween('now', '+1 year'),
        ];
    }

    public function expired(): static
    {
        return $this->state(fn () => [
            'status' => true,
            'expire_date' => fake()->dateTimeBetween('-1 year', 'now'),
        ]);
    }
}
