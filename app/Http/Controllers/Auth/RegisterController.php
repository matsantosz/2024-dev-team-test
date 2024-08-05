<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Data\UserData;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

final class RegisterController
{
    public function __construct(private readonly UserService $userService) {}

    public function __invoke(UserData $user): JsonResponse
    {
        $user = $this->userService->create($user);

        return new JsonResponse(
            data: [
                'message' => 'Register Success!',
                'data'    => $user->toArray(),
            ],
        );
    }
}
