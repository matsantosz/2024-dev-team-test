<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Resource;

final class ParticipantData extends Resource
{
    public function __construct(
        public string $name,
    ) {}
}
