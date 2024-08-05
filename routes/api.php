<?php

declare(strict_types=1);

use App\Http\Controllers\HolidayPlan\HolidayPlanController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->as('auth:')->group(
    base_path('routes/auth.php'),
);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource(
        name: 'holiday_plans',
        controller: HolidayPlanController::class,
    );
});
