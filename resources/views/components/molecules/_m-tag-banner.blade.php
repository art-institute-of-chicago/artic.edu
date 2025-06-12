<div class="m-tag-banner">
    @foreach($tags as $tag)
        @if(property_exists($tag, 'url') && property_exists($tag, 'label'))
            @component('components.atoms._link')
                @slot('variation', 'tag')
                @slot('font', 'f-tag')
                @slot('href', $tag->url )
                    {{ $tag->label }}
            @endcomponent
        @endif
    @endforeach
</div>
