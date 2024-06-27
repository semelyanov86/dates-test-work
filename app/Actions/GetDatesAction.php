<?php

declare(strict_types=1);

namespace App\Actions;

use App\Data\DatesData;
use App\Models\Date;

final class GetDatesAction
{
    /**
     * @return array<string, DatesData[]>
     */
    public function getAllDates(): array
    {
        $result = [];
        $dates = Date::all()->groupBy(fn (Date $date) => $date->date->format('Y-m-d'));
        foreach ($dates as $key => $date) {
            foreach ($date as $item) {
                $result[$key][] = DatesData::from($item);
            }
        }

        return $result;
    }
}
