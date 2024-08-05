<?php

declare(strict_types=1);

namespace App\Data;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

final class StoreHolidayPlanData extends Data
{
    public function __construct(
        public string $title,
        public string $description,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d')]
        public CarbonImmutable $date,
        public string $location,
        public ?string $participants,
    ) {}

    public static function rules($context): array
    {
        return [
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['required', 'string'],
            'date'         => ['required', 'string', 'date_format:Y-m-d'],
            'location'     => ['required', 'string', 'max:255'],
            'participants' => ['nullable', 'string', 'max:255'],
        ];
    }
}
