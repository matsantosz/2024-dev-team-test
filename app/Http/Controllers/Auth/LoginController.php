<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Data\CredentialsData;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

final class LoginController
{
    public function __construct(private readonly UserService $userService) {}

    public function __invoke(CredentialsData $credentials): JsonResponse
    {
        $user = User::where('email', $credentials->email)->first();

        if (!$user || !Hash::check($credentials->password, $user->password)) {
            throw ValidationException::withMessages([
                'credentials' => 'The provided credentials are incorrect.',
            ]);
        }

        $token = $user->createToken($credentials->email);

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
