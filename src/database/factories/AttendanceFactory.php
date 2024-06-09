<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 20),
            'date' => $this->faker->dateTimeBetween($startDate = '-1 week', $endDate = '1week'),
            'start_time' => $this->faker->time('09:00:00'),
            'end_time' => $this->faker->time('18:00:00'),
            'work_time' => $this->faker->time('08:00:00'),
        ];
    }
}
