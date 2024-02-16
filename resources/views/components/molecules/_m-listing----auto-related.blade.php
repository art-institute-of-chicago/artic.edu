@if ($item->url_without_slug)
    <{{ $tag ?? 'li' }} class="m-listing m-listing--article{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-behavior="blurMyBackground"' : '' !!}>
        <a href="{{ method_exists($item, 'getUrl') ? $item->getUrl() : $item->url_without_slug }}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
            @if ($isFeatured)
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
            @endif
            <div class="m-listing__meta"{{ (isset($variation) and strrpos($variation, "--hero") > -1) ? ' data-blur-clip-to' : '' }}>
                <span class="m-listing__types f-tag">{!! $item->subtype ? $item->present()->subtype : $item->type !!}
                    @if ($item->exclusive)
                        @component('components.atoms._type')
                            @slot('variation', 'type--membership')
                            @slot('font', '')
                            Member Exclusive
                        @endcomponent
                    @endif

                    @if ($item->isClosed)
                        @component('components.atoms._type')
                            @slot('variation', 'type--limited')
                            @slot('font', '')
                            Closed
                        @endcomponent
                    @else
                        @if ($item->isClosingSoon)
                            @component('components.atoms._type')
                                @slot('variation', 'type--limited')
                                @slot('font', '')
                                Closing Soon
                            @endcomponent
                        @elseif ($item->isNowOpen)
                            @component('components.atoms._type')
                                @slot('variation', 'type--new')
                                @slot('font', '')
                                Now Open
                            @endcomponent
                        @elseif ($item->exclusive)
                            @component('components.atoms._type')
                                @slot('variation', 'type--membership')
                                @slot('font', '')
                                Member Exclusive
                            @endcomponent
                        @endif
                    @endif
                </span>
                <br>
                @component('components.atoms._title')
                    @slot('font', $titleFont ?? 'f-list-3')
                    @slot('title', $item->present()->title)
                    @slot('title_display', $item->present()->title_display)
                @endcomponent
                <br>
                @if ($isFeatured)
                    @if ($item->present()->list_description)
                        <div class="intro {{ $captionFont ?? 'f-caption' }}">{!! $item->present()->list_description !!}</div>
                    @endif
                @endif
                @if (!$item->isOngoing)
                    @component('components.organisms._o-public-dates')
                        @slot('date', $item->present()->date)
                        @slot('dateStart', $item->present()->startAt)
                        @slot('dateEnd', $item->present()->endAt)
                        @slot('formattedDate', $item->present()->date_display_override)
                    @endcomponent
                @endif
            </div>
        </a>
    </{{ $tag ?? 'li' }}>
@endif
