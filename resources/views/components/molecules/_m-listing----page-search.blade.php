<{{ $tag ?? 'li' }} class="m-listing m-listing--inline m-listing--rtl{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{!! $item->url ?? $item->web_url !!}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        <span class="m-listing__title">
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-3')
                @slot('variation', 'title--w-right-arrow')
                @slot('gtmAttributes', $gtmAttributes ?? null)
                {!! $item->present()->title_display ?? $item->present()->title !!} <span class='title__arrow' aria-hidden="true">&rsaquo;</span>
            @endcomponent
        </span>
        <span class="m-listing__meta">
            <span class="intro {{ $captionFont ?? 'f-secondary' }}">
                {!! $item->present()->listing_description ?? '&nbsp;' !!}
            </span>
        </span>
        {{-- Don't leave space for image if it's missing --}}
        @if (isset($image) || $item->imageFront('default'))
            <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}">
                @component('components.atoms._img')
                    @slot('image', $image ?? $item->imageFront('default'))
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
                @component('components.molecules._m-listing-video')
                    @slot('item', $item)
                    @slot('image', $image ?? null)
                @endcomponent
            </span>
        @endif
    </a>
</{{ $tag ?? 'li' }}>
