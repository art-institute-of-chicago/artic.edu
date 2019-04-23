<{{ $tag ?? 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{!! $item->url !!}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        @if (!isset($hideImage) or (isset($hideImage) && !($hideImage)))
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
        @endif
        <span class="m-listing__meta">
            @if ($item->subtype)
            <em class="type f-tag">{{ $item->subtype }}</em>
            <br>
            @endif
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-3')
                @slot('variation', $titleVariation ?? '')
                @slot('title', $item->title)
                @slot('title_display', $item->title_display)
            @endcomponent

            @if (isset($item['links']) and $item['links'])
                <br>
                @if (count($item['links']) > 1)
                   <ul class="f-secondary" aria-labelledby="h-{{ Str::slug($item['title']) }}">
                @else
                  <span class="f-secondary last-child">
                @endif
                @foreach ($item['links'] as $link)
                    {!! count($item['links']) > 1 ? '<li>' : '<span>' !!}
                        @if (isset($link['external']) and $link['external'])
                            <a href="{!! $link['href'] !!}" target="_blank" class="external-link f-link">
                                {!! $link['label'] !!}<svg aria-hidden="true" class="icon--new-window"><use xlink:href="#icon--new-window" /></svg>
                            </a>
                        @else
                            @component('components.atoms._link')
                                @slot('href', $link['href'])
                                @slot('gtmAttributes', $gtmAttributes ?? null)
                                {!! $link['label'] !!}
                            @endcomponent
                        @endif
                    {!! count($item['links']) > 1 ? '</li>' : '</span>' !!}
                @endforeach
                {!! count($item['links']) > 1 ? '</ul>' : '</span>' !!}
            @else
                @if ($item->intro)
                <br>
                <span class="intro {{ $captionFont ?? 'f-secondary' }}">{{ $item->intro }}</span>
                @endif
                @if ($item->shortDesc)
                <br>
                <span class="intro {{ $captionFont ?? 'f-secondary' }}">{!! $item->shortDesc !!}</span>
                @endif
                @if ($item->listing_description)
                <br>
                <span class="intro {{ $captionFont ?? 'f-secondary' }}">{!! $item->listing_description !!}</span>
                @endif
            @endif

            {{-- TODO: Consider putting dates into .m-listing__meta-bottom? --}}
            @if (isset($date))
                @if(!empty($date))
                    <br>
                    @component('components.atoms._date')
                        {{ $date }}
                    @endcomponent
                @endif
            @else
                @if ($item->date && (!isset($childBlock)))
                    <br>
                    @component('components.atoms._date')
                        {{ $item->date }}
                    @endcomponent
                @endif
            @endif
        </span>
    </a>
</{{ $tag ?? 'li' }}>
