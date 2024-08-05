<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\HolidayPlan;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()
            ->createOne([
                'email' => 'matheus@buzzvel.com',
            ]);

        HolidayPlan::factory(10)
            ->has(Participant::factory()->count(rand(1, 5)))
            ->for($user)
            ->create();
    }
}
