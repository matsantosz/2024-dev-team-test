<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class HolidayPlan extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'date',
        'location',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'immutable_datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
