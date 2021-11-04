@php
    if (isset($variation) and ((strrpos($variation, '--hero') > 0) or (strrpos($variation, '--feature') > 0))) {
        $hoverBar = '';
    } else {
        $hoverBar = ' m-listing--hover-bar';
    }
@endphp
<{{ $tag ?? 'li' }} class="m-listing m-listing--w-meta-bottom{{ $hoverBar }}{{ (isset($variation)) ? ' '.$variation : '' }}{{ $item->closingSoon ? " m-listing--limited" : "" }}{{ $item->is_member_exclusive ? " m-listing--membership" : "" }}"{!! (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-behavior="blurMyBackground"' : '' !!} itemscope itemtype="http://schema.org/VisualArtsEvent">
    <a href="{{ route('events.show', $item) }}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        @if (!isset($hideImage) or (isset($hideImage) && !($hideImage)))
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
            @if (!isset($variation) or $variation !== 'm-listing--hero')
                @if ($item->is_member_exclusive)
                    @component('components.atoms._type')
                        @slot('variation', 'type--membership')
                        Member Exclusive
                    @endcomponent
                @elseif ($item->audience === \App\Models\Event::LUMINARY)
                    @component('components.atoms._type')
                        @slot('variation', 'type--membership')
                        Luminary
                    @endcomponent
                @else
                    @component('components.atoms._type')
                        {!! $item->present()->type !!}
                    @endcomponent
                @endif
                <br>
            @endif
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-3')
                @slot('title', $item->present()->title)
                @slot('title_display', $item->present()->title_display)
                @slot('itemprop', 'name')
            @endcomponent
            <br>
            <span class="m-listing__meta-bottom">
                @if (!empty($item->forced_date))
                    @component('components.atoms._date')
                        {!! $item->present()->forced_date !!}
                    @endcomponent
                @else
                    @if (isset($variation) && strrpos($variation, '--sidebar') > -1)
                        @component('components.atoms._date')
                            {!! $item->present()->nextOcurrenceDate !!} | {!! $item->present()->nextOcurrenceTime !!}
                        @endcomponent
                    @else
                        @component('components.atoms._date')
                            {!! $item->present()->nextOcurrenceDate !!}
                        @endcomponent
                        <br>
                        @component('components.atoms._date')
                            {!! $item->present()->nextOcurrenceTime !!}
                        @endcomponent
                    @endif
                @endif
            </span>
        </span>
    </a>
</{{ $tag ?? 'li' }}>
