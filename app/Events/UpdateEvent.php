<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UpdateEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $item;
    public $urls = [];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\App\Models\Event $item)
    {
        $this->item = $item;

        if ($item->is_published) {
            $this->urls = [
                route('events.show', $item, false),
                '/'
            ];
        }
    }
}
