<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HolidayPlan>
 */
final class HolidayPlanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'title'       => $this->faker->sentence(3),
            'description' => $this->faker->realText(),
            'date'        => $this->faker->dateTimeThisYear(),
            'location'    => $this->faker->country(),
        ];
    }
}
