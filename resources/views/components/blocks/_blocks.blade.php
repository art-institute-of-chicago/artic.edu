@foreach ($blocks as $block)
    @if ($block['type'] === 'text')
        @php
            $font = false;
            $variation = false;
            $tag = false;
            //
            if (isset($block['subtype'])) {
                $font = ($block['subtype'] === 'intro') ? 'f-deck' : $font;
            }
        @endphp
        @component('components.blocks._text')
            @slot('tag', ($tag ? $tag : null))
            @slot('variation', ($variation ? $variation : null))
            @slot('font', ($font ? $font : null))
            @slot('loopIndex', $loop->iteration)
            {{ $block['content'] }}
        @endcomponent
    @endif



    @if ($block['type'] === 'accordion')
        @component('components.organisms._o-accordion')
            @slot('items', $block['content'])
            @slot('loopIndex', $loop->iteration)
        @endcomponent
    @endif
@endforeach
