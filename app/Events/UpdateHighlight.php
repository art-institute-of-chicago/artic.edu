<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UpdateHighlight
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $item;
    public $urls = [];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\App\Models\Highlight $item)
    {
        $this->item = $item;
        if ($item->is_published) {
            $this->urls = [
                route('highlights.show', $item, false),
                '/'
            ];
        }
    }
}
