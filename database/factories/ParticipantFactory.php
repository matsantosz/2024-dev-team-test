<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\HolidayPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Participant>
 */
final class ParticipantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'holiday_plan_id' => HolidayPlan::factory(),
            'name'            => $this->faker->name(),
        ];
    }
}
