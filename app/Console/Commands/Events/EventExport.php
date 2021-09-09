<?php

namespace App\Console\Commands\Events;

use App\Models\Event;

use League\Csv\Writer;
use Illuminate\Support\Facades\Storage;

use Aic\Hub\Foundation\AbstractCommand as BaseCommand;

class EventExport extends BaseCommand
{
    protected $signature = 'event:export';

    protected $description = 'Export associations between CMS and ticketed events';

    protected $csv;

    private $filename = 'event-tickets.csv';

    public function handle()
    {
        $this->csv = Writer::createFromPath($this->getCsvPath(), 'w');

        $this->csv->insertOne([
            'event_id',
            'ticketed_event_id',
            'is_ticketed',
            'rsvp_link',
            'buy_button_text',
            'buy_button_caption',
        ]);

        foreach (Event::cursor() as $event) {
            $this->insertOne($event);
        }
    }

    private function insertOne($event)
    {
        $ticketedEvent = $event->apiModels('ticketedEvent', 'TicketedEvent')->first();

        if (!isset($ticketedEvent)) {
            return;
        }

        $row = [
            'event_id' => $event->id,
            'ticketed_event_id' => $ticketedEvent->id,
            'is_ticketed' => $event->is_ticketed,
            'rsvp_link' => $event->rsvp_link,
            'buy_button_text' => $event->buy_button_text,
            'buy_button_caption' => $event->buy_button_caption,
        ];

        $this->info(implode(',', $row));

        $this->csv->insertOne($row);
    }

    private function getCsvPath()
    {
        return Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . $this->filename;
    }
}
