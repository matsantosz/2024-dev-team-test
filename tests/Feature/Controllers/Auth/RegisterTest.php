<?php

declare(strict_types=1);

use function Pest\Laravel\postJson;

test('should ne able to register a new user', function () {
    $data = [
        'email'                 => 'test@example.com',
        'password'              => 'password',
        'password_confirmation' => 'password',
    ];

    $response = postJson(route('auth:register'), $data);
    $response->assertCreated();
    $response->assertJson([
        'message' => 'Register success!',
        'data'    => [
            'email' => 'test@example.com',
        ],
    ]);
});
