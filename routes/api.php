<?php

declare(strict_types=1);

use App\Http\Controllers\HolidayPlan\GeneratePdfController;
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
    Route::post(
        uri: 'holiday_plans/{holidayPlan}/generate',
        action: GeneratePdfController::class,
    )->name('holiday_plans.generate');
});
