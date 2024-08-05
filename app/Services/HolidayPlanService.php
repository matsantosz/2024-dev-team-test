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

    public function create(array $attributes, array $participants, User $forUser): HolidayPlan
    {
        return $this->databaseManager->transaction(
            callback: function () use ($attributes, $participants, $forUser) {
                $holidayPlan = $forUser->holidayPlans()->create($attributes);

                $this->createParticipants(
                    holidayPlan: $holidayPlan,
                    participants: $participants,
                );

                return $holidayPlan;
            },
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

    private function createParticipants(HolidayPlan $holidayPlan, array $participants): void
    {
        if (empty($participants)) {
            return;
        }

        $participants = collect($participants)->map(fn (string $name) => [
            'name' => $name,
        ]);

        $holidayPlan->participants()->createManyQuietly(
            records: $participants->toArray(),
        );
    }
}
