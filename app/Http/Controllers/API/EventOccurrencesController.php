<?php

namespace App\Http\Controllers\API;

use App\Repositories\EventRepository;

use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventOccurrencesController extends BaseController
{

    protected $eventRepository;

    protected $model = \App\Models\Event::class;

    protected $transformer = \App\Http\Transformers\EventOccurrenceTransformer::class;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function occurrences(Request $request)
    {

        return $this->collect( $request, function( $limit ) {

            return $this->eventRepository->getEventsFiltered(
                Carbon::now(), Carbon::tomorrow()->addMonths(6),
                null, null, null, null,
                $limit
            );

        });

    }

    public function validateId($id)
    {
        return true;
    }
}
