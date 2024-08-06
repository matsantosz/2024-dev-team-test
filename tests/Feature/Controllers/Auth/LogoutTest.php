<?php

declare(strict_types=1);
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\postJson;

test('should revoke all user tokens', function () {
    $user = User::factory()->createOne();
    $user->createToken($user->email);

    actingAs($user);

    assertDatabaseCount('personal_access_tokens', 1);

    $response = postJson(route('auth:logout'));
    $response->assertOk();
    $response->assertJson([
        'message' => 'Logged out! All tokens revoked.',
    ]);

    assertDatabaseCount('personal_access_tokens', 0);
});
