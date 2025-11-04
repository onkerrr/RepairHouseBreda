<?php

namespace Database\Factories;

use App\Models\RepairType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RepairType>
 */
class RepairTypeFactory extends Factory
{
    protected $model = RepairType::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word() . ' Repair',
            'description' => $this->faker->sentence(),
        ];
    }
// per merk graag 
}
