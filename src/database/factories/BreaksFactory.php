<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BreaksFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'attendance_id' => $this->faker->unique()->numberBetween(1, 400),
            'break_start' => $this->faker->dateTimeBetween($starttime = '12:00:00', $endTime = '13:00:00'),
            'break_end' => $this->faker->dateTimeBetween($starttime = '13:30:00', $endTime = '14:00:00'),
        ];
    }
}
