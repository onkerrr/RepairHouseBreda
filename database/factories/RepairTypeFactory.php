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
        $brands = [
            'iPhone' => [
                'Scherm vervanging',
                'Batterij vervanging',
                'Camera reparatie',
                'Oplaadpoort reparatie',
                'Water schade behandeling',
                'Back cover vervanging',
            ],
            'Samsung' => [
                'Display reparatie',
                'Batterij vervangen',
                'Camera module vervangen',
                'USB-C poort reparatie',
                'Software update & reset',
                'Achterkant glas vervangen',
            ],
            'Huawei' => [
                'Scherm reparatie',
                'Accu vervanging',
                'Laadpoort vervanging',
                'Speaker reparatie',
                'Microfoon reparatie',
            ],
            'OnePlus' => [
                'Display vervangen',
                'Batterij service',
                'Poort reparatie',
                'Camera reparatie',
            ],
            'Google Pixel' => [
                'Screen replacement',
                'Battery swap',
                'Charging port fix',
                'Back glass replacement',
            ],
            'Xiaomi' => [
                'Scherm reparatie',
                'Batterij vervangen',
                'Oplaadpoort reparatie',
                'Camera vervanging',
            ],
        ];

        $brand = $this->faker->randomElement(array_keys($brands));
        $description = $this->faker->randomElement($brands[$brand]);

        return [
            'brand' => $brand,
            'description' => $description,
        ];
    }
}
