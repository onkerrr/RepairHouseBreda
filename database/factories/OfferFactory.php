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
        $offers = [
            ['title' => 'iPhone Scherm Reparatie Actie', 'before' => 149.99, 'after' => 99.99],
            ['title' => 'Samsung Display Vervangen Korting', 'before' => 179.99, 'after' => 129.99],
            ['title' => 'Batterij Vervanging Special', 'before' => 79.99, 'after' => 59.99],
            ['title' => 'Waterschade Behandeling Aanbieding', 'before' => 99.99, 'after' => 79.99],
            ['title' => 'Camera Reparatie Voordeel', 'before' => 129.99, 'after' => 99.99],
            ['title' => 'Oplaadpoort Reparatie Deal', 'before' => 69.99, 'after' => 49.99],
            ['title' => '20% Korting op Alle Reparaties', 'before' => 199.99, 'after' => 159.99],
            ['title' => 'Back Cover Vervanging Actie', 'before' => 89.99, 'after' => 69.99],
            ['title' => 'Gratis Screenprotector bij Schermreparatie', 'before' => 159.99, 'after' => 139.99],
            ['title' => 'Voorjaarsactie: 15% Korting', 'before' => 249.99, 'after' => 212.49],
        ];

        $offer = $this->faker->randomElement($offers);
        $start = $this->faker->dateTimeBetween('-1 month', '+1 week');
        $end = $this->faker->dateTimeBetween($start, '+2 months');

        return [
            'created_by' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'title' => $offer['title'],
            'price_before' => $offer['before'],
            'price_after' => $offer['after'],
            'start_date' => $start,
            'end_date' => $end,
        ];
    }

    /**
     * Active offer
     */
    public function active(): static
    {
        $start = $this->faker->dateTimeBetween('-1 week', 'now');
        $end = $this->faker->dateTimeBetween('+1 week', '+1 month');

        return $this->state(fn (array $attributes) => [
            'start_date' => $start,
            'end_date' => $end,
        ]);
    }

    /**
     * Expired offer
     */
    public function expired(): static
    {
        $start = $this->faker->dateTimeBetween('-2 months', '-1 month');
        $end = $this->faker->dateTimeBetween($start, '-1 day');

        return $this->state(fn (array $attributes) => [
            'start_date' => $start,
            'end_date' => $end,
        ]);
    }

    /**
     * Upcoming offer
     */
    public function upcoming(): static
    {
        $start = $this->faker->dateTimeBetween('+1 day', '+1 week');
        $end = $this->faker->dateTimeBetween($start, '+2 months');

        return $this->state(fn (array $attributes) => [
            'start_date' => $start,
            'end_date' => $end,
        ]);
    }
}
