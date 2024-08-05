<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\HolidayPlan;
use Illuminate\Support\Collection;

final class ParticipantService
{
    public function createParticipants(HolidayPlan $holidayPlan, array $participants): void
    {
        if (empty($participants)) {
            return;
        }

        $participants = $this->parseData($participants);

        $holidayPlan->participants()->createManyQuietly(
            records: $participants->toArray(),
        );
    }

    public function syncParticipants(HolidayPlan $holidayPlan, array $participants): void
    {
        if (empty($participants)) {
            return;
        }

        $participants = $this->parseData($participants);

        $holidayPlan->participants()->delete();

        $holidayPlan->participants()->createManyQuietly(
            records: $participants->toArray(),
        );
    }

    private function parseData(array $participants): Collection
    {
        return collect($participants)->map(fn (string $name) => [
            'name' => $name,
        ]);
    }
}
