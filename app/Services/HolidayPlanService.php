<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\HolidayPlan;
use App\Models\User;
use Illuminate\Database\DatabaseManager;

final class HolidayPlanService
{
    public function __construct(
        private DatabaseManager $databaseManager,
    ) {}

    public function create(array $attributes, User $forUser): HolidayPlan
    {
        return $this->databaseManager->transaction(
            callback: fn () => $forUser->holidayPlans()->create(
                attributes: $attributes,
            ),
            attempts: 3,
        );
    }

    public function update(array $attributes, HolidayPlan $holidayPlan): bool
    {
        return $this->databaseManager->transaction(
            callback: fn () => $holidayPlan->update(
                attributes: $attributes,
            ),
            attempts: 3,
        );
    }

    public function delete(HolidayPlan $holidayPlan): ?bool
    {
        return $this->databaseManager->transaction(
            callback: fn () => $holidayPlan->delete(),
            attempts: 3,
        );
    }
}
