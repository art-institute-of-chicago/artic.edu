@php
    $ids = $block->browserIds('tour_stop');
    $tourStop = \App\Models\Api\TourStop::query()->ids($ids)->get(['title', 'web_url'])->first();
@endphp

@if (isset($tourStop))
    @component('components.molecules._m-listing----sound')
        @slot('item', (object) [
            'title' => $tourStop->title,
            'href' => $tourStop->web_url,
        ])
    @endcomponent
@endif
