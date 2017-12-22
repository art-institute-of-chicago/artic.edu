@foreach ($blocks as $block)
    @if ($block['type'] === 'text')
        @php
            $font = (isset($editorial) and $editorial) ? 'f-body-editorial' : false;
            $variation = false;
            $tag = false;
            //
            if (isset($block['subtype'])) {
                switch ($block['subtype']) {
                    case 'intro':
                        $font = 'f-deck';
                        break;
                    case 'heading-1':
                        $font = 'f-module-title-2';
                        $tag = 'h4';
                        break;
                    case 'heading-2':
                        $font = 'f-subheading-1';
                        $tag = 'h4';
                        break;
                }
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

    @if ($block['type'] === 'quote')
        @component('components.atoms._quote')
            {{ $block['content'] }}
        @endcomponent
    @endif

    @if ($block['type'] === 'hr')
        @component('components.atoms._hr')
        @endcomponent
    @endif

    @if ($block['type'] === 'accordion')
        @component('components.organisms._o-accordion')
            @slot('items', $block['content'])
            @slot('loopIndex', $loop->iteration)
        @endcomponent
    @endif

    @if ($block['type'] === 'media')
        @component('components.molecules._m-media')
            @slot('item', $block['content'])
        @endcomponent
    @endif

    @if ($block['type'] === 'become-a-member')
        @component('components.molecules._m-cta-banner----become-a-member')
        @endcomponent
    @endif

    @if ($block['type'] === 'newsletter-sign-up')
        @component('components.molecules._m-aside-newsletter')
            @slot('variation', (isset($block['variation']) && $block['variation'] ? $block['variation'] : null))
        @endcomponent
    @endif
@endforeach
