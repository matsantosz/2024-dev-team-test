<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Participant extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'holiday_plan_id',
        'name',
    ];

    public function holidayPlan(): BelongsTo
    {
        return $this->belongsTo(HolidayPlan::class);
    }
}
