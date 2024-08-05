<?php

declare(strict_types=1);

use App\Models\HolidayPlan;
use App\Models\Participant;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\patchJson;

beforeEach(function () {
    $this->user = User::factory()->createOne();
    actingAs($this->user);
});

test('should be able to update a holiday plan without participants', function () {
    $holidayPlan = HolidayPlan::factory()
        ->for($this->user)
        ->createOne();

    $data = [
        'title'    => 'South Korea Trip',
        'location' => 'South korea',
    ];

    $response = patchJson(route('holiday_plans.update', $holidayPlan), $data);
    $response->assertOk();

    $response->assertJson([
        'data' => [
            'title'        => 'South Korea Trip',
            'description'  => $holidayPlan->description,
            'location'     => 'South korea',
            'date'         => $holidayPlan->date->format('Y-m-d'),
            'participants' => [],
        ],
    ]);

    assertDatabaseHas('holiday_plans', [
        'title'    => 'South Korea Trip',
        'location' => 'South korea',
    ]);
});

test('should be able to update a holiday plan with participants', function () {
    $holidayPlan = HolidayPlan::factory()
        ->for($this->user)
        ->has(Participant::factory(3))
        ->createOne();

    assertDatabaseMissing('participants', [
        'name' => 'Taylor',
    ]);

    assertDatabaseMissing('participants', [
        'name' => 'Nuno',
    ]);

    $data = [
        'title'        => 'Japan Trip',
        'location'     => 'Japan',
        'participants' => 'Taylor,Nuno',
    ];

    $response = patchJson(route('holiday_plans.update', $holidayPlan), $data);
    $response->assertOk();

    $response->assertJson([
        'data' => [
            'title'        => 'Japan Trip',
            'description'  => $holidayPlan->description,
            'location'     => 'Japan',
            'date'         => $holidayPlan->date->format('Y-m-d'),
            'participants' => [
                [
                    'name' => 'Taylor',
                ],
                [
                    'name' => 'Nuno',
                ],
            ],
        ],
    ]);

    assertDatabaseHas('holiday_plans', [
        'title'    => 'Japan Trip',
        'location' => 'Japan',
    ]);

    assertDatabaseHas('participants', [
        'name' => 'Taylor',
    ]);

    assertDatabaseHas('participants', [
        'name' => 'Nuno',
    ]);
});

test('should trigger forbidden if wrong user', function () {
    $holidayPlan = HolidayPlan::factory()
        ->for($this->user)
        ->create();

    $wrongUser = User::factory()->createOne();

    actingAs($wrongUser);

    $response = patchJson(route('holiday_plans.update', $holidayPlan), []);
    $response->assertForbidden();
});
