<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\AuthManager;

final class UserController
{
    public function __construct(private readonly UserService $userService) {}

    public function __invoke(): User|Authenticatable|null
    {
        return $this->userService->user();
    }
}
