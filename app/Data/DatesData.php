<?php

declare(strict_types=1);

namespace App\Data;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;

final class DatesData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public Carbon $date,
    ) {}
}
