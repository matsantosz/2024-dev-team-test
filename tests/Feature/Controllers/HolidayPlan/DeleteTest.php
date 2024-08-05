<?php

declare(strict_types=1);

use App\Models\HolidayPlan;
use App\Models\Participant;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;

beforeEach(function () {
    $this->user = User::factory()->createOne();
    actingAs($this->user);
});

test('should be able to delete a holiday plans', function () {
    $holidayPlan = HolidayPlan::factory()
        ->for($this->user)
        ->createOne();

    assertDatabaseCount('holiday_plans', 1);
    assertDatabaseHas('holiday_plans', $holidayPlan->only('id', 'title'));

    $response = deleteJson(route('holiday_plans.destroy', $holidayPlan));
    $response->assertNoContent();

    assertDatabaseCount('holiday_plans', 0);
    assertDatabaseMissing('holiday_plans', $holidayPlan->only('id', 'title'));
});

test('should also delete participants after destroy', function () {
    $holidayPlan = HolidayPlan::factory()
        ->for($this->user)
        ->createOne();

    $participant = Participant::factory()
        ->for($holidayPlan)
        ->createOne();

    assertDatabaseCount('holiday_plans', 1);
    assertDatabaseHas('holiday_plans', $holidayPlan->only('id', 'title'));

    assertDatabaseCount('participants', 1);
    assertDatabaseHas('participants', $participant->only('name'));

    $response = deleteJson(route('holiday_plans.destroy', $holidayPlan));
    $response->assertNoContent();

    assertDatabaseCount('holiday_plans', 0);
    assertDatabaseMissing('holiday_plans', $holidayPlan->only('id', 'title'));

    assertDatabaseCount('participants', 0);
    assertDatabaseMissing('participants', $participant->only('name'));
});

test('should trigger forbidden if wrong user', function () {
    $holidayPlan = HolidayPlan::factory()
        ->for($this->user)
        ->create();

    $wrongUser = User::factory()->createOne();

    actingAs($wrongUser);

    $response = deleteJson(route('holiday_plans.destroy', $holidayPlan));
    $response->assertForbidden();
});
