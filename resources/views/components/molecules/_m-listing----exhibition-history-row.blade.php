<{{ $tag ?? 'li' }} class="m-listing m-listing--w-meta-bottom m-listing--hover-bar{{ (!$item->slug) ? ' s-no-link' : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}" itemscope itemtype="http://schema.org/ExhibitionEvent">
    <a href="{{ route('exhibitions.show', $item) }}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        @if ($item->imageFront('hero'))
            <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}">
                @component('components.atoms._img')
                    @slot('image', $item->imageFront('hero'))
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
            </span>
        @endif
        <span class="m-listing__meta">
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-4')
                @slot('title', $item->present()->title)
                @slot('title_display', $item->present()->title_display)
            @endcomponent
            <br>
            <span class="intro {{ $captionFont ?? 'f-secondary' }}">{!! $item->present()->list_description !!}</span>
            <br>
            <span class="m-listing__meta-bottom">
                @component('components.atoms._date')
                    {!! $item->present()->formattedDateCanonical !!}
                @endcomponent
            </span>
        </span>
    </a>
</{{ $tag ?? 'li' }}>
