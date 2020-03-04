<?php

namespace App\Console\Commands\Events;

use App\Models\Event;
use App\Models\ApiRelation;
use App\Models\Api\TicketedEvent;

use League\Csv\Reader;
use Illuminate\Support\Facades\Storage;

use Aic\Hub\Foundation\AbstractCommand as BaseCommand;

class EventImport extends BaseCommand
{

    protected $signature = 'event:import';

    protected $description = 'Import associations between CMS and ticketed events';

    protected $csv;

    private $filename = 'event-tickets.csv';

    public function handle()
    {
        $csv = Reader::createFromPath($this->getCsvPath(), 'r');
        $csv->setHeaderOffset(0);

        $output = [
            'not_changed' => [],
            'not_found' => [],
            'ticketed_not_found' => [],
            'updated' => [],
        ];

        foreach ($csv as $offset => $record) {
            $event = Event::find($record['event_id']);

            if (!$event) {
                $this->warn('Event not found:' . $record['event_id']);
                $output['not_found'][] = $record['event_id'];
                continue;
            }

            $event->rsvp_link = $record['rsvp_link'];
            $event->buy_button_text = $record['buy_button_text'];
            $event->buy_button_caption = $record['buy_button_caption'];

            Event::withoutEvents(function() use ($event) {
                $event->save();
            });

            $newTicketedEvent = TicketedEvent::query()->find($record['ticketed_event_id']);

            if ($newTicketedEvent->error ?? false) {
                $this->warn('Ticketed event #' . $record['ticketed_event_id'] . ' not found for event #' . $record['event_id']);
                $output['ticketed_not_found'][] = $record['event_id'];
                continue;
            }

            $oldTicketedEvent = $event->apiModels('ticketedEvent', 'TicketedEvent')->first();

            if ($oldTicketedEvent) {
                if ($oldTicketedEvent->id !== intval($record['ticketed_event_id'])) {
                    if (!$this->confirm('Change ticketed event for event #' . $record['event_id'] . ' from ' . $oldTicketedEvent->id . ' to ' . $record['ticketed_event_id'] . '?')) {
                        continue;
                    }
                } else {
                    $this->comment('Same ticketed event #' . $record['ticketed_event_id'] . ' for event #' . $record['event_id']);
                    $output['not_changed'][] = $record['event_id'];
                    continue;
                }
            }

            $event->is_ticketed = $record['is_ticketed'];

            Event::withoutEvents(function() use ($event) {
                $event->save();
            });

            $event->ticketedEvent()->detach();

            $relatedElement = ApiRelation::firstOrCreate(['datahub_id' => $record['ticketed_event_id']]);
            $event->ticketedEvent()->attach([
                $relatedElement->id => [
                    'relation' => 'ticketedEvent',
                    'position' => 1,
                ]
            ]);

            $this->info('Attached ticketed event #' . $record['ticketed_event_id'] . ' to event #' . $record['event_id']);
            $output['updated'][] = $record['event_id'];
        }

        dd(json_encode($output));
    }

    private function getCsvPath()
    {
        return Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . $this->filename;
    }
}
