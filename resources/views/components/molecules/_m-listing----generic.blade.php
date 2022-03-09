<{{ $tag ?? 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{!! $item->present()->url !!}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        @if (!isset($hideImage) || (isset($hideImage) && !($hideImage)))
            @if ((isset($image) || $item->imageFront('default') || $item->imageFront('hero') || $item->imageFront('listing')))
                <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}">
                    @component('components.atoms._img')
                        @slot('image', $image ?? $item->imageFront('default') ?? $item->imageFront('hero') ?? $item->imageFront('listing'))
                        @slot('settings', $imageSettings ?? '')
                    @endcomponent
                    @component('components.molecules._m-listing-video')
                        @slot('item', $item)
                        @slot('image', $image ?? null)
                    @endcomponent
                </span>
            @elseif (isset($hideImage) && !$hideImage)
                <span class="default-img"></span>
            @endif
        @endif
        <span class="m-listing__meta">
            @if ($item->subtype)
                <em class="type f-tag">{!! $item->present()->subtypeForSearch ?? $item->present()->subtype !!}</em>
                <br>
            @endif
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-3')
                @slot('variation', $titleVariation ?? '')
                @slot('title', $item->present()->title)
                @slot('title_display', $item->present()->title_display)
            @endcomponent
            @if (!isset($hideDescription) || (isset($hideDescription) && !($hideDescription)))
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
                    @php
                        $listDescription = $item->present()->shortDesc
                            ?? $item->present()->listing_description
                            ?? $item->present()->list_description
                            ?? $item->present()->intro
                            ?? null;
                    @endphp
                    @if (!empty($listDescription))
                        <br>
                        <span class="intro {{ $captionFont ?? 'f-secondary' }}">{!! $listDescription !!}</span>
                    @endif
                @endif
                {{-- WEB-2238: Consider putting dates into .m-listing__meta-bottom? --}}
                @if (isset($date))
                    @if(!empty($date))
                        <br>
                        @component('components.atoms._date')
                            {{ $date }}
                        @endcomponent
                    @endif
                @else
                    {{-- WEB-2239: We should probably remove this everywhere... why would we want to display unformatted dates? --}}
                    @if ($item->date && (!isset($hideDate)))
                        <br>
                        @component('components.atoms._date')
                            {{ $item->date }}
                        @endcomponent
                    @endif
                @endif
            @endif
        </span>
    </a>
</{{ $tag ?? 'li' }}>
