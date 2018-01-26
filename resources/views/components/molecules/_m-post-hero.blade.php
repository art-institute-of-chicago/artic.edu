<article class="m-post-hero">
    <div class="m-post-hero__inner">
        <figure class="m-post-hero__image">
            <a href="#">
                @component('components.atoms._img')
                    @slot('src', $post->image['src'])
                    @slot('srcset', $post->image['srcset'])
                    @slot('width', $post->image['width'])
                    @slot('height', $post->image['height'])
                @endcomponent
            </a>
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
