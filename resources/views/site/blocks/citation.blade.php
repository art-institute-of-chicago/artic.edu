@component('components.atoms._hr')
@endcomponent
@component('components.blocks._text')
    @slot('font', 'f-subheading-1')
    @slot('tag', 'h4')
    Citation
@endcomponent
@component('components.blocks._text')
    @slot('font', 'f-secondary')
    {!! $block->input('citation') !!}
@endcomponent
