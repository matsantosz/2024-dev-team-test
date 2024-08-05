<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\HolidayPlan;
use App\Models\User;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->createOne([
            'email' => 'matheus@buzzvel.com',
        ]);

        HolidayPlan::factory(10)->for($user)->create();
    }
}
