@if (!empty($themes))
    @component('components.atoms._hr')
        @slot('variation','hr--flush-top')
    @endcomponent
    @php
        $themeString = 'It seems it you could also be interested in ';
        $themesLength = sizeof($themes);
        $themesIndex = 1;
        foreach ($themes as $theme) {
            if ($themesIndex > 1 && $themesIndex < $themesLength) {
                $themeString .= ', ';
            }
            if ($themesIndex === $themesLength) {
                $themeString .= ' and ';
            }
            $themeString .= '<a href="'.$theme['href'].'" data-gtm-event-category="collection-nav" data-gtm-event="you-might-like">'.$theme['label'].'</a>';
            if ($themesIndex === $themesLength) {
                $themeString .= '.';
            }
            $themesIndex++;
        }
    @endphp
    @component('components.blocks._text')
        @slot('variation','interests-list')
        @slot('font','f-list-2')
        @slot('tag','p')
        {!! $themeString !!}
    @endcomponent
@endif
