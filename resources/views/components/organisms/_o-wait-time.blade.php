@if (!empty($waitTime))
    @component('components.molecules._m-link-list----item')
        @slot('link', [
            'name' => 'Average wait time: ' . $waitTime->present()->display,
            'label' => 'Average wait time: ' . $waitTime->present()->display
        ])
    @endcomponent
@endif
