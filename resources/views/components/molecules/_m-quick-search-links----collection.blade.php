<div class="m-quick-search-links">
    <ul class="m-quick-search-links__links" data-behavior="dragScroll">
    @foreach ($links as $link)
        <li>
            @component('components.atoms._tag')
                @slot('variation', 'tag--w-image')
                @slot('href', $link['href'])
                @component('components.atoms._img')
                    @slot('image', $link['image'])
                    @slot('settings', array(
                        'fit' => 'crop',
                        'ratio' => '1:1',
                        'srcset' => array(20,40),
                        'sizes' => '40px',
                    ))
                @endcomponent
                {{ $link['label'] }}
            @endcomponent
        </li>
    @endforeach
    </ul>
</div>
