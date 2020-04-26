<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TileMedia
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $item;

    public $forceRetile;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\A17\Twill\Models\Media $item, bool $forceRetile)
    {
        $this->item = $item;

        $this->forceRetile = $forceRetile;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
