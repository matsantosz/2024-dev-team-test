<?php

declare(strict_types=1);

use App\Models\HolidayPlan;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

beforeEach(function () {
    $this->user = User::factory()->createOne();
    actingAs($this->user);
});

test('should be able to create a holiday plan without participants', function () {
    $holidayPlan = HolidayPlan::factory()->makeOne();

    $data = [
        'title'       => $holidayPlan->title,
        'description' => $holidayPlan->description,
        'location'    => $holidayPlan->location,
        'date'        => now()->format('Y-m-d'),
    ];

    assertDatabaseCount('holiday_plans', 0);

    $response = postJson(route('holiday_plans.store'), $data);
    $response->assertCreated();
    $response->assertJson([
        'data' => $data,
    ]);

    assertDatabaseCount('holiday_plans', 1);

    assertDatabaseHas('holiday_plans', [
        'title'       => $holidayPlan->title,
        'description' => $holidayPlan->description,
        'location'    => $holidayPlan->location,
    ]);
});

test('should be able to create a holiday plan with participants', function () {
    $holidayPlan = HolidayPlan::factory()->makeOne();

    $data = [
        'title'        => $holidayPlan->title,
        'description'  => $holidayPlan->description,
        'location'     => $holidayPlan->location,
        'date'         => now()->format('Y-m-d'),
        'participants' => 'Matheus,Lucas,Marcos',
    ];

    assertDatabaseCount('holiday_plans', 0);
    assertDatabaseCount('participants', 0);

    $response = postJson(route('holiday_plans.store'), $data);
    $response->assertCreated();
    $response->assertJson([
        'data' => [
            'title'        => $holidayPlan->title,
            'description'  => $holidayPlan->description,
            'location'     => $holidayPlan->location,
            'date'         => now()->format('Y-m-d'),
            'participants' => [
                [
                    'name' => 'Matheus',
                ],
                [
                    'name' => 'Lucas',
                ],
                [
                    'name' => 'Marcos',
                ],
            ],
        ],
    ]);

    assertDatabaseCount('holiday_plans', 1);
    assertDatabaseCount('participants', 3);

    assertDatabaseHas('holiday_plans', [
        'title'       => $holidayPlan->title,
        'description' => $holidayPlan->description,
        'location'    => $holidayPlan->location,
    ]);

    assertDatabaseHas('participants', [
        'name' => 'Matheus',
    ]);

    assertDatabaseHas('participants', [
        'name' => 'Lucas',
    ]);

    assertDatabaseHas('participants', [
        'name' => 'Marcos',
    ]);
});
