<div class="o-gallery o-gallery--mosaic">
    @if (isset($title))
        <h3 class="o-gallery__title f-module-title-2">{!! $title !!}</h3>
    @endif
    <div class="o-gallery__caption">
        <hr>
        @if (isset($caption))
            @component('components.blocks._text')
                @slot('font','f-caption')
                {!! $caption !!}
            @endcomponent
        @endif
        @component('components.atoms._btn')
            @slot('variation', 'btn--quinary btn--icon o-gallery__share')
            @slot('font', '')
            @slot('icon', 'icon--share--24')
        @endcomponent
    </div>
    <div class="o-gallery__media">
        @if (isset($items))
            @foreach ($items as $item)
                @component('components.molecules._m-media')
                    @slot('item', $item)
                @endcomponent
            @endforeach
        @endif
    </div>
</div>
