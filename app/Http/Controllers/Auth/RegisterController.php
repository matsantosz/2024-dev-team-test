<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Data\UserData;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class RegisterController
{
    public function __construct(private readonly UserService $userService) {}

    public function __invoke(UserData $user): JsonResponse
    {
        $user = $this->userService->create($user);

        return new JsonResponse(
            data: [
                'message' => 'Register success!',
                'data'    => $user->toArray(),
            ],
            status: Response::HTTP_CREATED,
        );
    }
}
