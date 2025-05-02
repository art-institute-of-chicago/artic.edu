<div class="m-tag-banner">
    @foreach($block->repeater('link_tag') as $tag)
        @component('components.atoms._link')
            @slot('variation', 'm-tag-banner__tag')
            @slot('href', $tag->url)
                {{ $tag->label }}
        @endcomponent
    @endforeach
</div>
