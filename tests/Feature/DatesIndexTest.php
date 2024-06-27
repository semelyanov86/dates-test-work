<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Date;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class DatesIndexTest extends TestCase
{
    use RefreshDatabase;

    public function testRowsIndex(): void
    {
        $response = $this->get(route('dates.index'));

        $response->assertStatus(200);
    }

    public function test_it_has_data(): void
    {
        /** @var Date $date */
        $date = Date::factory()->createOne();

        $response = $this->get(route('dates.index'));

        $response->assertStatus(200);
        $response->assertSee($date->name);
    }
}
