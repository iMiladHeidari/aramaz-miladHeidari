<?php

namespace App\Events;

use App\Models\TableA;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RecordCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $table_a_id;
    public $star_count;

    /**
     * Create a new event instance.
     */
    public function __construct(TableA $table_a)
    {
        $this->table_a_id = $table_a->id;
        $this->star_count = $table_a->user_star;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
