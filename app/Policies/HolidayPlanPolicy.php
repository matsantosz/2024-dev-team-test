<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\HolidayPlan;
use App\Models\User;

final class HolidayPlanPolicy
{
    public function view(User $user, HolidayPlan $holidayPlan): bool
    {
        return $holidayPlan->user_id === $user->id;
    }

    public function update(User $user, HolidayPlan $holidayPlan): bool
    {
        return $holidayPlan->user_id === $user->id;
    }

    public function delete(User $user, HolidayPlan $holidayPlan): bool
    {
        return $holidayPlan->user_id === $user->id;
    }
}
