
{{-- DEPRECATED: Used only in 1 view so moved there.  --}}
{{-- site/research_resources/index.blade.php --}}

<article class="m-post-hero">
    <figure class="m-post-hero__image">
        @component('components.atoms._img')
            @slot('image', $post->image)
            @slot('settings', $imageSettings ?? '')
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
</article>
