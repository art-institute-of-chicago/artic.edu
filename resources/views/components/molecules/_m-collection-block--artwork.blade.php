<li class="m-listing">
    <a href="{!! route('artworks.show', ['id' => $item->id, 'slug' => $item->titleSlug ]) !!}" class="m-listing__link">
        <span class="m-collection__img m-collection__img--no-bg">
            @if (isset($image) || $item->imageFront())
                @component('components.atoms._img')
                    @slot('image', $image ?? $item->imageFront())
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
                @component('components.molecules._m-listing-video')
                    @slot('item', $item)
                    @slot('image', $image ?? null)
                @endcomponent
            @else
                <span class="default-img"></span>
            @endif
        </span>
    </a>
</li>
