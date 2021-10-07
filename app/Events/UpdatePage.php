<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

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
}
