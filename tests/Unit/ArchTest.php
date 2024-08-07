<?php

declare(strict_types=1);

arch('avoid dumps', function () {
    expect(['dd', 'ddd', 'dump', 'var_dump'])->not->toBeUsed();
});

arch('use strict types', function () {
    expect('App')->toUseStrictTypes();
    expect('Database')->toUseStrictTypes();
});

arch('use final classes', function () {
    expect('App')->classes()->toBeFinal();
    expect('Database')->classes()->toBeFinal();
});
