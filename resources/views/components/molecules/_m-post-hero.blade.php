<article class="m-post-hero">
    <div class="m-post-hero__inner">
        <figure class="m-post-hero__image">
            @component('components.atoms._img')
                @slot('image', $post->image)
                @slot('sizes', $imageSizes ?? '')
            @endcomponent
        </figure>

        <div class="m-post-hero__main">
            @component('components.blocks._text')
                @slot('font','f-list-4')
                @slot('tag','h3')
                {{ $post->primary }}
            @endcomponent

            @if ( !empty( $post->secondary ) )
                @component('components.blocks._text')
                    @slot('font','f-body')
                    {{ $post->secondary }}
                @endcomponent
            @endif
        </div>
    </div>
</article>
