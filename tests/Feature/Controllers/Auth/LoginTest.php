<?php

declare(strict_types=1);
use App\Models\User;

use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\postJson;

test('should create a bearer token', function () {
    $user = User::factory()->createOne();

    $data = [
        'email'    => $user->email,
        'password' => 'password',
    ];

    $response = postJson(route('auth:login'), $data);
    $response->assertOk();
    $response->assertJson([
        'message' => 'You\'re logged in!',
    ]);
});
