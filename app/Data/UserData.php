<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;

final class UserData extends Data
{
    public function __construct(
        public string $email,
        public string $password,
    ) {}

    public static function rules($context): array
    {
        return [
            'email'    => ['required', 'string', 'email', 'unique:users,email', 'max:255'],
            'password' => ['required', 'string', 'confirmed', 'min:8', 'max:255'],
        ];
    }
}
