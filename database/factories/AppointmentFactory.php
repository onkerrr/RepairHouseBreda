<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\User;
use App\Models\RepairType;
use App\AppointmentStatus;
use App\AppointmentSubStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $issueDescriptions = [
            'Scherm is gebarsten na val',
            'Telefoon gaat niet meer aan',
            'Batterij loopt snel leeg',
            'Oplaadpoort werkt niet goed',
            'Camera maakt onscherpe foto\'s',
            'Touchscreen reageert niet',
            'Water schade, telefoon viel in water',
            'Achterkant glas is gebroken',
            'Geluid werkt niet meer',
            'Microfoon valt weg tijdens bellen',
            'Face ID werkt niet meer',
            'Trilmotor werkt niet',
            'Home button reageert niet',
            'Volume knoppen werken niet',
            'Telefoon wordt erg warm',
        ];

        $status = $this->faker->randomElement([
            AppointmentStatus::Pending,
            AppointmentStatus::InProgress,
            AppointmentStatus::Completed,
            AppointmentStatus::Cancelled,
        ]);

        $subStatus = null;
        if ($status === AppointmentStatus::InProgress && $this->faker->boolean(60)) {
            $subStatus = $this->faker->randomElement([
                AppointmentSubStatus::WaitingForParts,
                AppointmentSubStatus::ContactCustomer,
                AppointmentSubStatus::CancelledRepair,
            ]);
        }

        // 20% van appointments zonder user (admin-created)
        $userId = $this->faker->boolean(20) 
            ? null 
            : (User::inRandomOrder()->first()?->id ?? User::factory());

        return [
            'user_id' => $userId,
            'repair_type_id' => RepairType::inRandomOrder()->first()?->id ?? RepairType::factory(),
            'appointment_date' => $this->faker->dateTimeBetween('-2 weeks', '+1 month'),
            'issue_description' => $this->faker->randomElement($issueDescriptions),
            'status' => $status,
            'sub_status' => $subStatus,
            'estimated_repair_duration' => $this->faker->randomElement([30, 45, 60, 90, 120, 180]),
        ];
    }

    /**
     * Appointment without user (admin-created)
     */
    public function withoutUser(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => null,
        ]);
    }

    /**
     * Pending appointment
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => AppointmentStatus::Pending,
            'sub_status' => null,
            'appointment_date' => $this->faker->dateTimeBetween('now', '+2 weeks'),
        ]);
    }

    /**
     * In progress appointment
     */
    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => AppointmentStatus::InProgress,
            'sub_status' => $this->faker->randomElement([
                AppointmentSubStatus::WaitingForParts,
                AppointmentSubStatus::ContactCustomer,
                AppointmentSubStatus::CancelledRepair,
            ]),
            'appointment_date' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ]);
    }

    /**
     * Completed appointment
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => AppointmentStatus::Completed,
            'sub_status' => null,
            'appointment_date' => $this->faker->dateTimeBetween('-1 month', '-1 day'),
        ]);
    }

    /**
     * Cancelled appointment
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => AppointmentStatus::Cancelled,
            'sub_status' => null,
        ]);
    }
}
