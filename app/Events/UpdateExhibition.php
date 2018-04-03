<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateExhibition
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $item;
    public $urls;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\App\Models\Exhibition $item)
    {
        $this->item = $item;
        $this->urls = [
            route('exhibitions.show', $item->getApiModelFilled(), false),
            '/'
        ];
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
