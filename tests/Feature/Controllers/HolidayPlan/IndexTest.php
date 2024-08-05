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

test('should be able to retrieve all holiday plans', function () {
    HolidayPlan::factory(3)
        ->for($this->user)
        ->create();

    $response = getJson(route('holiday_plans.index'));
    $response->assertOk();
    $response->assertJsonCount(3, 'data');

    $response->assertJsonStructure([
        'data' => [
            [
                'id',
                'title',
                'description',
                'location',
                'date',
                'participants',
            ],
        ],
    ]);
});

test('should be able to retrieve participants', function () {
    $holidayPlan = HolidayPlan::factory()
        ->for($this->user)
        ->createOne();

    $participants = Participant::factory(2)
        ->for($holidayPlan)
        ->create();

    $response = getJson(route('holiday_plans.index'));
    $response->assertOk();
    $response->assertJsonCount(1, 'data');

    $response->assertJson([
        'data' => [
            [
                'participants' => [
                    [
                        'name' => $participants[0]->name,
                    ],
                    [
                        'name' => $participants[1]->name,
                    ],
                ],
            ],
        ],
    ]);
});
