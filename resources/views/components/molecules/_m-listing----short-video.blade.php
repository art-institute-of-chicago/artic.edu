<li class="m-listing">
    @component('components.atoms._link')
        @slot('dataHref', $url)
        @slot('variation', 'm-listing__link')
        @slot('behavior', 'triggerShortsPlayerModal')
        @slot('gtmAttributes', 'data-gtm-event-action="' . addslashes($title) . '"')

        <span class="m-listing__img">
            @if (isset($image))
                @component('components.atoms._img')
                    @slot('image', $image)
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
            @else
                <span class="default-img"></span>
            @endif
            @if ($label && $labelPosition == 'overlay')
                <span class="m-listing__img-prompt f-buttons">
                    {{ $label }}
                </span>
            @endif
        </span>
        <span class="m-listing__meta">
            @if (isset($tag))
                <em class="type f-tag">{!! $tag !!}</em>
                <br>
            @endif
            @if (isset($title))
                @component('components.atoms._title')
                    @slot('font', 'f-list-3')
                    @slot('title', $title)
                @endcomponent
            @endif
            @if (isset($description))
                <br>
                <span class="intro f-secondary">{!! $description !!}</span>
            @endif
            @if ($label && $labelPosition == 'description')
            <span class="f-link">
                {{ $label }} <svg class='icon--arrow'><use xlink:href='#icon--arrow'></use></svg>
            </span>
        @endif
        </span>
    @endcomponent
</li>
