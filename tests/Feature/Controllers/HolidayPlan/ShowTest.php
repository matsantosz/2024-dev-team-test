<?php

declare(strict_types=1);

use App\Models\HolidayPlan;
use App\Models\Participant;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

beforeEach(function () {
    $this->user = User::factory()->createOne();
    actingAs($this->user);
});

test('should be able to retrieve a specific holiday plan', function () {
    $holidayPlan = HolidayPlan::factory()
        ->for($this->user)
        ->create();

    $response = getJson(route('holiday_plans.show', $holidayPlan));
    $response->assertOk();

    $response->assertJson([
        'data' => [
            'id'           => $holidayPlan->id,
            'title'        => $holidayPlan->title,
            'description'  => $holidayPlan->description,
            'location'     => $holidayPlan->location,
            'date'         => $holidayPlan->date->format('Y-m-d'),
            'participants' => [],
        ],
    ]);
});

test('should be able to retrieve participants of holiday plan', function () {
    $holidayPlan = HolidayPlan::factory()
        ->for($this->user)
        ->create();

    $participants = Participant::factory(2)
        ->for($holidayPlan)
        ->create();

    $response = getJson(route('holiday_plans.show', $holidayPlan));
    $response->assertOk();

    $response->assertJson([
        'data' => [
            'id'           => $holidayPlan->id,
            'title'        => $holidayPlan->title,
            'description'  => $holidayPlan->description,
            'location'     => $holidayPlan->location,
            'date'         => $holidayPlan->date->format('Y-m-d'),
            'participants' => [
                [
                    'name' => $participants[0]->name,
                ],
                [
                    'name' => $participants[1]->name,
                ],
            ],
        ],
    ]);
});

test('should trigger forbidden if wrong user', function () {
    $holidayPlan = HolidayPlan::factory()
        ->for($this->user)
        ->create();

    $wrongUser = User::factory()->createOne();

    actingAs($wrongUser);

    $response = getJson(route('holiday_plans.show', $holidayPlan));
    $response->assertForbidden();
});
