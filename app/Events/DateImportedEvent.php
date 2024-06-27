<?php

declare(strict_types=1);

namespace App\Events;

use App\Data\DatesData;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class DateImportedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        protected readonly DatesData $datesData
    ) {}

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('Dates');
    }
}
