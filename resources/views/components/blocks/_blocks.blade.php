@if ($blocks)
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
                        case 'secondary':
                            $font = 'f-secondary';
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

                @if (isset($editorial) and $editorial and $loop->first and !$loop->parent and isset($dropCapFirstPara) and $dropCapFirstPara)
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
                @slot('variation', (isset($editorial) and $editorial) ? 'quote--editorial o-blocks__block' : 'o-blocks__block')
                @slot('font', (isset($editorial) and $editorial) ? 'f-deck' : null)
                {{ $block['content'] }}
            @endcomponent
        @endif

        @if ($block['type'] === 'hr')
            @component('components.atoms._hr')
            @endcomponent
        @endif

        @if ($block['type'] === 'accordion')
            @component('components.organisms._o-accordion')
                @slot('variation', 'o-blocks__block')
                @slot('items', $block['content'])
                @slot('loopIndex', $loop->iteration)
            @endcomponent
        @endif

        @if ($block['type'] === 'media')
            @component('components.molecules._m-media')
                @slot('variation', 'o-blocks__block')
                @slot('item', $block['content'])
            @endcomponent
        @endif

        @if ($block['type'] === 'become-a-member')
            @component('components.molecules._m-cta-banner----become-a-member')
                @slot('variation', 'o-blocks__block')
            @endcomponent
        @endif

        @if ($block['type'] === 'newsletter-sign-up')
            @if (isset($block['subtype']) and $block['subtype'] === 'inline')
                @component('components.molecules._m-inline-aside')
                    @component('components.molecules._m-aside-newsletter')
                        @slot('variation','m-aside-newsletter--inline o-blocks__block')
                        @slot('placeholder','Email Address')
                    @endcomponent
                @endcomponent
            @else
                @component('components.molecules._m-aside-newsletter')
                    @slot('variation', (isset($block['subtype']) && $block['subtype'] ? 'm-aside-newsletter--'.$block['subtype'].' o-blocks__block' : 'o-blocks__block'))
                @endcomponent
            @endif
        @endif

        @if ($block['type'] === 'time-line')
            @component('components.organisms._o-row-listing')
                @slot('variation', 'o-blocks__block')
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
                    @slot('variation', 'o-blocks__block')
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
                    @slot('variation', 'o-blocks__block')
                    @slot('type', $block['subtype'])
                    @slot('items', $block['items'])
                    @slot('itemsMolecule', '_m-listing----'.$block['subtype'].'-row')
                    @slot('itemsVariation', 'm-listing--inline'.(($block["subtype"] === 'product') ? ' m-listing--inline-feature' : ''))
                @endcomponent
            @endif
        @endif

        @if ($block['type'] === 'link-list')
            @component('components.molecules._m-link-list')
                @slot('variation', 'o-blocks__block')
                @slot('links', $block['links']);
            @endcomponent
        @endif

        @if ($block['type'] === 'gallery')
            @if (isset($block['subtype']) and $block['subtype'])
                @component('components.organisms._o-gallery----'.$block["subtype"])
                    @slot('variation', 'o-blocks__block')
                    @slot('title', $block['title']);
                    @slot('caption', $block['caption']);
                    @slot('items', $block['items']);
                @endcomponent
            @endif
        @endif

        @if ($block['type'] === 'unorderedList')
            <ul class="list {{ ((isset($editorial) and $editorial) ? 'f-body-editorial' : 'f-body') }}">
            @foreach ($block['items'] as $item)
                <li>{{ $item }}</li>
            @endforeach
            </ul>
        @endif

        @if ($block['type'] === 'orderedList')
            <ol class="list {{ ((isset($editorial) and $editorial) ? 'f-body-editorial' : 'f-body') }}">
            @foreach ($block['items'] as $item)
                <li>{{ $item }}</li>
            @endforeach
            </ol>
        @endif

        @if ($block['type'] === 'references')
            <ol class="list f-secondary">
            @foreach ($block['items'] as $item)
                <li id="ref_note-{{ $item['id'] }}">{{ $item['reference'] }} <a class="return-link" href="#ref_cite-{{ $item['id'] }}"><svg class="icon--return" aria-label="back to reference"><use xlink:href="#icon--return"></use></svg></a></li>
            @endforeach
            </ol>
        @endif

        @if ($block['type'] === 'embed')
            @slot('variation', 'o-blocks__block')
            {!! $block['content'] !!}
        @endif

        @if ($block['type'] === 'deflist')
            <dl class="deflist o-blocks__block">
            @foreach ($block['items'] as $item)
                <div class="deflist__row">
                <dt class="f-module-title-1">{{ $item['key'] }}</dt>
                    <dd class="f-secondary">{{ $item['value'] }}</dd>
                </div>
            @endforeach
            </dl>
        @endif

    @endforeach
@endif
