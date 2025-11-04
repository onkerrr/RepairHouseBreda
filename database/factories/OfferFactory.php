<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Offer;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{
    protected $model = Offer::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-1 month', 'now');
        $end = $this->faker->dateTimeBetween($start, '+1 month');

        return [
            'created_by' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'title' => $this->faker->sentence(3),
            'price_before' => $this->faker->randomFloat(2, 50, 500),
            'price_after' => $this->faker->randomFloat(2, 30, 450),
            'start_date' => $start,
            'end_date' => $end,
        ];
    }
}
