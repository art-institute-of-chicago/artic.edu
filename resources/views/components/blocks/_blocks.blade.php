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
            $content = $block['content'];
        @endphp
        @component('components.blocks._text')
            @slot('tag', ($tag ? $tag : null))
            @slot('variation', ($variation ? $variation : null))
            @slot('font', ($font ? $font : null))
            @slot('loopIndex', $loop->iteration)

            @if (isset($editorial) and $editorial and $loop->first) {
                @component('components.blocks._text')
                    @slot('font','f-dropcap-editorial')
                    @slot('tag','span')
                    @php echo substr($content, 0, 1) @endphp
                @endcomponent
                @php echo substr($content, 1) @endphp
            @else
                {!! $content !!}
            @endif
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

    @if ($block['type'] === 'time-line')
        @component('components.organisms._o-row-listing')
            @foreach ($block['items'] as $item)
                @component('components.molecules._m-listing----timeline')
                    @slot('date', $item)
                @endcomponent
            @endforeach
        @endcomponent
    @endif

    @if ($block['type'] === 'listing')
        @if (isset($block['subtype']) and $block['subtype'])
            @component('components.organisms._o-row-listing')
                @foreach ($block['items'] as $item)
                    @component('components.molecules._m-listing----'.$block["subtype"].'-row')
                        @slot('variation', 'm-listing--inline'.(($block["subtype"] === 'product') ? ' m-listing--inline-feature' : ''))
                        @slot($block["subtype"], $item)
                    @endcomponent
                @endforeach
            @endcomponent
        @endif
    @endif

    @if ($block['type'] === 'aside')
        @if (isset($block['subtype']) and $block['subtype'])
            @component('components.blocks._inline-aside')
                @if (sizeof($block["items"]) === 1)
                    @slot('title', 'Related '.ucfirst($block["subtype"]))
                    @component('components.molecules._m-listing----'.$block["subtype"].'-row')
                        @slot('tag', 'p')
                        @slot('variation', 'm-listing--inline'.(($block["subtype"] === 'product') ? ' m-listing--inline-feature' : ''))
                        @slot($block["subtype"], $block["items"][0])
                    @endcomponent
                @else
                    @slot('title', 'Related '.ucfirst($block["subtype"]).'s')
                    @component('components.organisms._o-row-listing')
                        @foreach ($block['items'] as $item)
                            @component('components.molecules._m-listing----'.$block["subtype"].'-row')
                                @slot('variation', 'm-listing--inline'.(($block["subtype"] === 'product') ? ' m-listing--inline-feature' : ''))
                                @slot($block["subtype"], $item)
                            @endcomponent
                        @endforeach
                    @endcomponent
                @endif
            @endcomponent
        @endif
    @endif

    @if ($block['type'] === 'link-list')
        @component('components.molecules._m-link-list')
            @slot('links', $block['links']);
        @endcomponent
    @endif
@endforeach
