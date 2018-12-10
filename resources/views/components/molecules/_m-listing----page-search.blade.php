<{{ $tag or 'li' }} class="m-listing m-listing--inline m-listing--rtl{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{!! $item->url ?? $item->web_url !!}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>

        <span class="m-listing__title">
            @component('components.atoms._title')
                @slot('variation', 'title--w-right-arrow')
                @slot('gtmAttributes', $gtmAttributes ?? null)
                {{ $item['title_display'] ?? $item['title'] }} <span class='title__arrow' aria-hidden="true">&rsaquo;</span>
            @endcomponent
        </span>

        <span class="m-listing__meta">
            @if ($item->listing_description)
            <span class="intro {{ $captionFont ?? 'f-secondary' }}">{!! $item->listing_description !!}</span>
            @endif
        </span>

        {{-- Don't leave space for image if it's missing --}}
        @if (isset($image) || $item->imageFront('default'))
            <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}">
                @component('components.atoms._img')
                    @slot('image', $image ?? $item->imageFront('default'))
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
                @if ($item->videoFront)
                    @component('components.atoms._video')
                        @slot('video', $item->videoFront)
                        @slot('autoplay', true)
                        @slot('loop', true)
                        @slot('muted', true)
                        @slot('title', $item->videoFront['fallbackImage']['alt'] ?? $item->imageFront('default')['alt'] ?? $image['alt'] ?? null)
                    @endcomponent
                    @component('components.atoms._media-play-pause-video')
                    @endcomponent
                @endif
            </span>
        @endif

    </a>
</{{ $tag or 'li' }}>
