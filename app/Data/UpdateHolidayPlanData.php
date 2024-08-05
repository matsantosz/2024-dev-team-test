<?php

declare(strict_types=1);

namespace App\Data;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

final class UpdateHolidayPlanData extends Data
{
    public function __construct(
        public ?string $title,
        public ?string $description,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d')]
        public ?CarbonImmutable $date,
        public ?string $location,
        public ?string $participants,
    ) {}

    public static function rules($context): array
    {
        return [
            'title'        => ['nullable', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'date'         => ['nullable', 'string', 'date_format:Y-m-d'],
            'location'     => ['nullable', 'string', 'max:255'],
            'participants' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function toAttributes(): array
    {
        return collect($this->toArray())->filter()->toArray();
    }
}
