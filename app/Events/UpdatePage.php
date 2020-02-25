<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdatePage
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $item;
    public $urls = [];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\App\Models\Page $item)
    {
        $this->item = $item;
        if ($item->is_published) {
            $this->urls = [
                route('events', null, false),
                route('exhibitions', null, false),
                route('collection', null, false),
                route('visit', null, false),
                route('articles', null, false),
                '/'
            ];
        }
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
