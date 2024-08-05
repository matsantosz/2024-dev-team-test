<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;

final class LogoutController
{
    public function __construct(private readonly UserService $userService) {}

    public function __invoke(): JsonResponse
    {
        $user = $this->userService->user();

        $this->userService->rekoveTokens(
            user: $user,
        );

        return new JsonResponse([
            'message' => 'Logged out! All tokens revoked.',
        ]);
    }
}
