<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UpdatePageFeature
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
    public function __construct(\App\Models\PageFeature $item)
    {
        $this->item = $item;

        if ($item->is_published) {
            $this->urls = [
                '/'
            ];
        }
    }
}
