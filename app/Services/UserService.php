<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\CredentialsData;
use App\Data\UserData;
use App\Models\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\AuthManager;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\NewAccessToken;

final readonly class UserService
{
    public function __construct(
        private AuthManager $authManager,
        private DatabaseManager $databaseManager,
    ) {}

    public function create(UserData $user): User
    {
        return $this->databaseManager->transaction(
            callback: fn () => User::query()->create(
                attributes: [
                    'email'    => $user->email,
                    'password' => Hash::make($user->password),
                ],
            ),
            attempts: 3,
        );
    }

    public function createToken(User $user, string $name): NewAccessToken
    {
        return $this->databaseManager->transaction(
            callback: function () use ($user, $name) {
                $user->tokens()->delete();

                return $user->createToken($name);
            },
            attempts: 3,
        );
    }

    public function login(CredentialsData $credentials): bool
    {
        return $this->authManager->attempt(
            credentials: [
                'email'    => $credentials->email,
                'password' => $credentials->password,
            ],
        );
    }

    public function user(): User|Authenticatable|null
    {
        return $this->authManager->user();
    }
}
