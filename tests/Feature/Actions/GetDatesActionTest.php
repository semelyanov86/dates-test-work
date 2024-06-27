<?php

declare(strict_types=1);

namespace Tests\Feature\Actions;

use App\Actions\GetDatesAction;
use App\Data\DatesData;
use App\Models\Date;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class GetDatesActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_dates_returns_grouped_data(): void
    {
        Date::factory()->create(['name' => 'Event 1', 'date' => '2023-10-15']);
        Date::factory()->create(['name' => 'Event 2', 'date' => '2023-10-15']);
        Date::factory()->create(['name' => 'Event 3', 'date' => '2023-10-16']);
        $action = new GetDatesAction();
        $result = $action->getAllDates();

        // Assertion
        $this->assertCount(2, $result);
        $this->assertArrayHasKey('2023-10-15', $result);
        $this->assertArrayHasKey('2023-10-16', $result);
        $this->assertCount(2, $result['2023-10-15']);
        $this->assertInstanceOf(DatesData::class, $result['2023-10-15'][0]);
        $this->assertInstanceOf(DatesData::class, $result['2023-10-15'][1]);
        $this->assertCount(1, $result['2023-10-16']);
        $this->assertInstanceOf(DatesData::class, $result['2023-10-16'][0]);
    }
}
