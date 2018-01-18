<div class="m-quick-search-links">
    <ul class="m-quick-search-links__links" data-behavior="dragScroll">
    @foreach ($links as $link)
        <li>
            @component('components.atoms._tag')
                @slot('variation', 'tag--w-image')
                @slot('href', $link['href'])
                @component('components.atoms._img')
                    @slot('src', $link['image']['src'])
                    @slot('width', $link['image']['width'])
                    @slot('height', $link['image']['height'])
                @endcomponent
                {{ $link['label'] }}
            @endcomponent
        </li>
    @endforeach
    </ul>
</div>
