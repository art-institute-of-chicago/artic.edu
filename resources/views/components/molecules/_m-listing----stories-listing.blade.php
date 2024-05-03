@if ($item->url_without_slug)
    <{{ $tag ?? 'li' }} class="stories-listing m-listing--article{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-behavior="blurMyBackground"' : '' !!}>
        <a href="{{ method_exists($item, 'getUrl') ? $item->getUrl() : $item->url_without_slug }}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
            <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}{{ ($item->videoFront) ? ' m-listing__img--video' : '' }}"{{ (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-blur-img' : '' }}>
                @if (isset($image) || $item->imageFront('hero'))
                    @if ($isHero ?? false)
                        @component('components.atoms._img')
                            @slot('image', $image ?? $item->imageFront('hero'))
                            @slot('settings', $imageSettings ?? '')
                            @slot('class', 'img-hero-desktop')
                        @endcomponent
                        @component('components.atoms._img')
                            @slot('image', $imageMobile ?? $item->imageFront('mobile_hero') ?? $image ?? $item->imageFront('hero'))
                            @slot('settings', $imageSettings ?? '')
                            @slot('class', 'img-hero-mobile')
                        @endcomponent
                    @else 
                        @component('components.atoms._img')
                            @slot('image', $image ?? $item->imageFront('hero'))
                            @slot('settings', $imageSettings ?? '')
                        @endcomponent
                    @endif
                    @component('components.molecules._m-listing-video')
                        @slot('item', $item)
                        @slot('image', $image ?? null)
                    @endcomponent
                @else
                    <span class="default-img"></span>
                @endif
                <span class="m-listing__img__overlay"></span>
            </span>
            <div class="m-listing__meta"{{ (isset($variation) and strrpos($variation, "--hero") > -1) ? ' data-blur-clip-to' : '' }}>
                @component('components.atoms._title')
                    @slot('font', $titleFont ?? 'f-list-3')
                    @slot('title', $item->present()->title)
                    @slot('title_display', $item->present()->title_display)
                @endcomponent
                <br>
                @if ($isFeatured)
                    @if (isset($item->authors) && (count($item->authors) > 0) || $item->author_display)
                        <div class="author f-body-editorial">
                            @if ($item->author_display)
                                by ⁠{!! $item->author_display !!}
                            @elseif (count($item->authors) > 0)
                                <span class="author__name">
                                    by {{StringHelpers::summation($item->authors->pluck('title')->all())}}                                </span>
                            @endif
                        </div>
                    @endif
                    @if ($item->present()->list_description)
                        <div class="intro {{ $captionFont ?? 'f-caption' }}">{!! $item->present()->list_description !!}</div>
                    @endif
                @endif
                @if ((isset($item->authors) && (count($item->authors) > 0) || $item->author_display) && !$isFeatured)
                    <div class="author f-body-editorial">
                        @if ($item->author_display)
                            by ⁠{!! $item->author_display !!}
                        @elseif (count($item->authors) > 0)
                            <span class="author__name">
                                by {{StringHelpers::summation($item->authors->pluck('title')->all())}}
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </a>
    </{{ $tag ?? 'li' }}>
@endif
