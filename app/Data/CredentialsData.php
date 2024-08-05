<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;

final class CredentialsData extends Data
{
    public function __construct(
        public string $email,
        public string $password,
    ) {}

    public static function rules($context): array
    {
        return [
            'email'    => ['required'],
            'password' => ['required'],
        ];
    }
}
