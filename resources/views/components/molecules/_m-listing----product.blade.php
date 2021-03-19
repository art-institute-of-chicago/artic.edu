<{{ $tag ?? 'li' }} class="m-listing m-listing--w-meta-bottom">
    <a href="{!! $item->web_url !!}" class="m-listing__link" target="_blank">
        <span class="m-listing__img m-listing__img--tall">
            @if ($item->imageFront())
                @component('components.atoms._img')
                    @slot('image', $item->imageFront())
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
        </span>
    </a>
</{{ $tag ?? 'li' }}>
