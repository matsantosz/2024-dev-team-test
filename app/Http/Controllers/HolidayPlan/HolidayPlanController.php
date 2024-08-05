<?php

declare(strict_types=1);

namespace App\Http\Controllers\HolidayPlan;

use App\Data\HolidayPlanData;
use App\Data\StoreHolidayPlanData;
use App\Data\UpdateHolidayPlanData;
use App\Models\HolidayPlan;
use App\Services\HolidayPlanService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

final class HolidayPlanController
{
    public function __construct(
        private readonly HolidayPlanService $holidayPlanService,
        private readonly UserService $userService,
    ) {}

    public function index(): JsonResponse
    {
        $user = $this->userService->user();

        return new JsonResponse([
            'data' => HolidayPlanData::collect($user->holidayPlans),
        ]);
    }

    public function store(StoreHolidayPlanData $data): JsonResponse
    {
        $holidayPlan = $this->holidayPlanService->create(
            attributes: $data->toArray(),
            forUser: $this->userService->user(),
        );

        return new JsonResponse(
            data: [
                'data' => HolidayPlanData::from($holidayPlan),
            ],
            status: Response::HTTP_CREATED,
        );
    }

    public function show(HolidayPlan $holidayPlan): JsonResponse
    {
        Gate::authorize('view', $holidayPlan);

        return new JsonResponse([
            'data' => HolidayPlanData::from($holidayPlan),
        ]);
    }

    public function update(UpdateHolidayPlanData $data, HolidayPlan $holidayPlan): JsonResponse
    {
        Gate::authorize('update', $holidayPlan);

        $this->holidayPlanService->update(
            attributes: $data->toAttributes(),
            holidayPlan: $holidayPlan,
        );

        return new JsonResponse([
            'data' => HolidayPlanData::from($holidayPlan),
        ]);
    }

    public function destroy(HolidayPlan $holidayPlan): JsonResponse
    {
        Gate::authorize('delete', $holidayPlan);

        $this->holidayPlanService->delete($holidayPlan);

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
