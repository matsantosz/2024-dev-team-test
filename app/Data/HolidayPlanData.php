<?php

declare(strict_types=1);

namespace App\Data;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;
use Spatie\LaravelData\Attributes\LoadRelation;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Resource;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

final class HolidayPlanData extends Resource
{
    public function __construct(
        public string $id,
        public string $title,
        public string $description,
        public string $location,

        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d')]
        public CarbonImmutable $date,

        /** @var Collection<ParticipantData> */
        #[LoadRelation]
        public Collection $participants,
    ) {}
}
