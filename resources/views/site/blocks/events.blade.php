@php
    use App\Repositories\EventRepository;
    use App\Models\Event;
    use Carbon\Carbon;

    $now = Carbon::now();
    $dateStart = $block->input('date_start') ? Carbon::parse($block->input('date_start')) : $now;
    $dateEnd = $block->input('date_end') ? Carbon::parse($block->input('date_end')) : Carbon::tomorrow()->addMonths(6);

    if ($dateStart->lt($now)) {
        $dateStart = $now;
    }

    $events = (new EventRepository(new Event))->getEventsFiltered(
        $dateStart,
        $dateEnd,
        null,
        $block->input('type'),
        $block->input('audience'),
        $block->input('program'),
        4,
        null,
        false,
        function (&$query) {
            $query->getQuery()->orders = null;
            $query->orderBy('event_metas.date', 'ASC');
        }
    );

    $items = $events->map(function($event) use ($block) {
        $href = route('events.show', $event);
        $gtmEvent = UrlHelpers::lastUrlSegment($href);

        return [
            'title' => $event->title_display ?? $event->title,
            'dateDisplay' => $event->present()->formattedBlockDate(),
            'href' => $href,
            'gtmAttributes' => 'data-gtm-event="' . $gtmEvent . '" data-gtm-event-category="mag-content-' . $block->position . '"',
        ];
    });
@endphp

@if ($items && $items->count() > 0)
    @component('components.molecules._m-listing----publication-happenings')
        @slot('variation', 'm-listing--publication-happenings--events m-listing--magazine')
        @slot('title', $block->input('title') ?? null)
        @slot('btnText', 'See all events')
        @slot('btnHref', route('events'))
        @slot('items', $items)
        @slot('gtmAttributes', 'data-gtm-event="events" data-gtm-event-category="mag-content-' . $block->position . '"')
    @endcomponent
@endif
