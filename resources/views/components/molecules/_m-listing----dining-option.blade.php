<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">

    <span class="m-listing__img m-listing__img--wide">
        @component('components.atoms._img')
            @slot('src', $item['image']['src'])
            @slot('width', $item['image']['width'])
            @slot('height', $item['image']['height'])
        @endcomponent
    </span>
    <span class="m-listing__meta">
        @component('components.atoms._title')
            @slot('font', $titleFont ?? 'f-list-3')
            {{ $item['title'] }}
        @endcomponent
        <br>
        @component('components.blocks._text')
            @slot('font', 'f-secondary')
            @slot('tag', 'span')
            {{ $item['text'] }}
        @endcomponent
    </span>

</{{ $tag or 'li' }}>
