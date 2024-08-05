<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('auth')->as('auth:')->group(
    base_path('routes/auth.php'),
);