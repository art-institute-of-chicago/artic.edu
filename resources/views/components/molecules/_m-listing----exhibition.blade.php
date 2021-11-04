@php
    if (isset($variation) and ((strrpos($variation, '--hero') > 0) or (strrpos($variation, '--feature') > 0))) {
        $hoverBar = '';
    } else {
        $hoverBar = ' m-listing--hover-bar';
    }
@endphp
<{{ $tag ?? 'li' }} class="m-listing m-listing--w-meta-bottom{{ $hoverBar }}{{ (isset($variation)) ? ' '.$variation : '' }}{{ $item->isClosingSoon ? " m-listing--limited" : "" }}{{ $item->isNowOpen ? " m-listing--new" : "" }}{{ $item->exclusive ? " m-listing--membership" : "" }}"{!! (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-behavior="blurMyBackground"' : '' !!} itemscope itemtype="http://schema.org/ExhibitionEvent">
    <a href="{!! route('exhibitions.show', $item) !!}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        @if (!isset($hideImage) || (isset($hideImage) && !($hideImage)))
            <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}{{ ($item->videoFront) ? ' m-listing__img--video' : '' }}"{{ (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-blur-img' : '' }}>
                @if (isset($image) || $item->imageFront('hero'))
                    @component('components.atoms._img')
                        @slot('image', $image ?? $item->imageFront('hero'))
                        @slot('settings', $imageSettings ?? '')
                    @endcomponent
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
        <span class="m-listing__meta"{{ (isset($variation) and strrpos($variation, "--hero") > -1) ? ' data-blur-clip-to' : '' }}>
            <span class="m-listing__types f-tag">
                @if ($item->exclusive)
                    @component('components.atoms._type')
                        @slot('variation', 'type--membership')
                        @slot('font', '')
                        Member Exclusive
                    @endcomponent
                @else
                    @component('components.atoms._type')
                        @slot('font', '')
                        {!! $item->present()->exhibitionType !!}
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
            @php
                $showDescription = (
                    !isset($hideDescription) || (
                        isset($hideDescription) && !($hideDescription)
                    )
                ) && (
                    !empty($variation) &&
                    strpos($variation, 'm-listing--hero') === false &&
                    strpos($variation, 'm-listing--feature') === false &&
                    $item->list_description
                );
            @endphp
            {{-- WEB-2018: For related content, we want to hide the description, but show dates --}}
            @if ($showDescription)
                @component('components.atoms._short-description')
                    {!! StringHelpers::truncateStr($item->present()->list_description) !!}
                @endcomponent
                <br>
            @endif
            @if (!empty($variation) && $variation === 'm-listing--hero')
                @component('components.organisms._o-preview-dates')
                    @slot('previewDateStart', $item->member_preview_start_date)
                    @slot('previewDateEnd', $item->member_preview_end_date)
                @endcomponent
                <br>
            @endif
            @if (!$item->isOngoing)
                @component('components.organisms._o-public-dates')
                    @slot('date', $item->present()->date)
                    @slot('dateStart', $item->present()->startAt)
                    @slot('dateEnd', $item->present()->endAt)
                    @slot('formattedDate', $item->present()->date_display_override)
                @endcomponent
            @endif
        </span>
    </a>
</{{ $tag ?? 'li' }}>
