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
        private ParticipantService $participantService,
    ) {}

    public function create(array $attributes, array $participants, User $forUser): HolidayPlan
    {
        return $this->databaseManager->transaction(
            callback: function () use ($attributes, $participants, $forUser) {
                $holidayPlan = $forUser->holidayPlans()->create($attributes);

                $this->participantService->createParticipants(
                    holidayPlan: $holidayPlan,
                    participants: $participants,
                );

                return $holidayPlan;
            },
            attempts: 3,
        );
    }

    public function update(array $attributes, array $participants, HolidayPlan $holidayPlan): bool
    {
        return $this->databaseManager->transaction(
            callback: function () use ($attributes, $participants, $holidayPlan) {
                $this->participantService->syncParticipants(
                    holidayPlan: $holidayPlan,
                    participants: $participants,
                );

                return $holidayPlan->update($attributes);
            },
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
