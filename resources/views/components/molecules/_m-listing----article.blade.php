<{{ $tag ?? 'li' }} class="m-listing m-listing--article{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-behavior="blurMyBackground"' : '' !!}>
    <a href="{!! route(($module ?? 'articles') .'.show', $item) !!}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        @if (!isset($hideImage) || (isset($hideImage) && !($hideImage)))
            <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}{{ ($item->videoFront) ? ' m-listing__img--video' : '' }}"{{ (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-blur-img' : '' }}>
                @if (isset($image) || $item->imageFront('hero'))
                    @component('components.atoms._img')
                        @slot('image', $image ?? $item->imageFront('hero'))
                        @slot('settings', $imageSettings ?? '')
                    @endcomponent
                    @if ($item->videoFront)
                        @component('components.atoms._video')
                            @slot('video', $item->videoFront)
                            @slot('autoplay', true)
                            @slot('loop', true)
                            @slot('muted', true)
                            @slot('title', $item->videoFront['fallbackImage']['alt'] ?? $item->imageFront('hero')['alt'] ?? $image['alt'] ?? null)
                        @endcomponent
                        @component('components.atoms._media-play-pause-video')
                        @endcomponent
                    @endif
                @else
                    <span class="default-img"></span>
                @endif
                @if ($item->isVideo)
                    <svg class="icon--play--48"><use xlink:href="#icon--play--48" /></svg>
                @endif
                <span class="m-listing__img__overlay"></span>
            </span>
        @endif
        <div class="m-listing__meta"{{ (isset($variation) and strrpos($variation, "--hero") > -1) ? ' data-blur-clip-to' : '' }}>
            <em class="type f-tag">{!! $subtype ?? $item->present()->subtype !!}</em>
            <br>
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-3')
                @slot('title', $item->present()->title)
                @slot('title_display', $item->present()->title_display)
            @endcomponent
            <br>
            @if (!isset($hideDescription) || (isset($hideDescription) && !($hideDescription)))
                <div class="intro {{ $captionFont ?? 'f-caption' }}">{!! $item->present()->list_description !!}</div>
            @endif
        </div>
    </a>
</{{ $tag ?? 'li' }}>
