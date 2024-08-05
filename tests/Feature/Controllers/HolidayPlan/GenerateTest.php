<?php

declare(strict_types=1);

use App\Models\HolidayPlan;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

beforeEach(function () {
    $this->user = User::factory()->createOne();
    actingAs($this->user);
});

test('should be able to generate a pdf for a holiday plan', function () {
    $holidayPlan = HolidayPlan::factory()
        ->for($this->user)
        ->create();

    $response = postJson(route('holiday_plans.generate', $holidayPlan));
    $response->assertOk();
    $response->assertHeader('Content-Type', 'application/pdf');

    $response->assertHeader(
        'Content-Disposition',
        "attachment; filename=\"{$holidayPlan->title}.pdf\"",
    );
});
