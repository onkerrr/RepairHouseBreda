<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone_number' => fake()->boolean(80) ? '06' . fake()->numerify('########') : null,
            'email_verified_at' => now(),
            'password' => static::$password ??= 'password',
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * User with phone number
     */
    public function withPhone(): static
    {
        return $this->state(fn (array $attributes) => [
            'phone_number' => '06' . fake()->numerify('########'),
        ]);
    }

    /**
     * User without phone number
     */
    public function withoutPhone(): static
    {
        return $this->state(fn (array $attributes) => [
            'phone_number' => null,
        ]);
    }
}
