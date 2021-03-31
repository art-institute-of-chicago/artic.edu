<{{ $tag ?? 'li' }} class="m-listing m-listing--publication m-listing--publication-call-to-action m-listing--w-meta-bottom{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{{ $href ?? '' }}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        <span class="m-listing__meta">
            @if (isset($type))
                @component('components.atoms._type')
                    {!! $type !!}
                @endcomponent
                <br>
            @endif
            <div class="m-listing__title">
                @if (isset($title_display))
                    @component('components.atoms._title')
                        @slot('font', 'f-headline')
                        @slot('title_display', $title_display)
                        @slot('itemprop', 'name')
                    @endcomponent
                @endif
            </div>
            @if (isset($link_text))
                <br>
                <span class="m-listing__meta-bottom">
                    <span class="btn f-buttons btn--magazine">{{ $link_text }}</span>
                </span>
            @endif
        </span>
    </a>
</{{ $tag ?? 'li' }}>
