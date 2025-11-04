<?php

namespace Database\Factories;


use App\Models\Appointment;
use App\Models\User;
use App\Models\RepairType;
use App\AppointmentStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'repair_type_id' => RepairType::inRandomOrder()->first()?->id ?? RepairType::factory(),
            'appointment_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'issue_description' => $this->faker->sentence(),
            'status' => AppointmentStatus::Pending->value,
            'estimated_repair_duration' => $this->faker->numberBetween(30, 180),
        ];
    }
}
