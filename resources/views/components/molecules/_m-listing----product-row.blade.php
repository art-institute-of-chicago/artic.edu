<{{ $tag ?? 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{!! $item->web_url !!}" class="m-listing__link" target="_blank"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '  m-listing__img--tall' }}">
            @if ($item->imageFront('hero'))
                @component('components.atoms._img')
                    @slot('image', $item->imageFront('hero'))
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
            @else
                <span class="default-img"></span>
            @endif
        </span>
        <span class="m-listing__meta">
            @component('components.atoms._title')
                {!! $item->present()->title !!}
            @endcomponent
            <br>
            @component('components.atoms._short-description')
                {!! $item->present()->description !!}
            @endcomponent
        </span>
    </a>
</{{ $tag ?? 'li' }}>
