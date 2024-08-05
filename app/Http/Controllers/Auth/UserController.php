<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\AuthManager;

class UserController
{
    public function __construct(private AuthManager $auth) {}

    public function __invoke(): User|Authenticatable|null
    {
        return $this->auth->user();
    }
}
