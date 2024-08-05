<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Data\CredentialsData;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

final class LoginController
{
    public function __construct(private readonly UserService $userService) {}

    public function __invoke(CredentialsData $credentials): JsonResponse
    {
        $authenticated = $this->userService->login($credentials);

        if (!$authenticated) {
            throw ValidationException::withMessages([
                'credentials' => 'The provided credentials are incorrect.',
            ]);
        }

        $token = $this->userService->createToken(
            user: $this->userService->user(),
            name: $credentials->email,
        );

        return new JsonResponse(
            data: [
                'message' => 'You\'re logged in!',
                'data'    => [
                    'access_token' => $token->plainTextToken,
                ],
            ],
        );
    }
}
