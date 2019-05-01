@php
    $ids = $block->browserIds('tour_stop');
    $tourStop = \App\Models\Api\TourStop::query()->ids($ids)->get(['title', 'web_url', 'transcript'])->first();
@endphp

@if (isset($tourStop))
    @component('components.molecules._m-listing----sound')
        @slot('item', (object) [
            'title' => $tourStop->present()->title,
            'href' => $tourStop->web_url,
            'transcript' => $tourStop->present()->transcript,
            'subtitle' => 'Hear the full tour on our app, available for <a href="https://itunes.apple.com/us/app/art-institute-of-chicago-app/id1130366814?mt=8">Apple</a> and <a href="https://play.google.com/store/apps/details?id=edu.artic">Android</a>',
        ])
    @endcomponent
@endif
