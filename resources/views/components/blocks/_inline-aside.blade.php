@component('components.molecules._m-inline-aside')
    @slot('variation', $variation ?? null)
    @if (sizeof($items) === 1)
        @if (isset($type))
            @slot('title', 'Related '.ucfirst($type))
        @endif
        @component('components.molecules.'.$itemsMolecule)
            @slot('tag', 'span')
            @slot('variation', $itemsVariation ?? null)
            @slot('item', $items[0])
            @slot('fullscreen', false)
            @slot('imageSettings', $imageSettings ?? null)
            @slot('titleFont', $titleFont ?? null)
            @slot('hideShortDesc', $hideShortDesc ?? null)
            @slot('gtmAttributes', $gtmAttributes ?? null)
        @endcomponent
    @else
        @if (isset($type))
            @slot('title', 'Related '.ucfirst($type).'s')
        @endif
        @component('components.organisms._o-row-listing')
            @foreach ($items as $item)
                @component('components.molecules.'.$itemsMolecule)
                    @slot('variation', $itemsVariation ?? null)
                    @slot('item', $item)
                    @slot('fullscreen', false)
                    @slot('imageSettings', $imageSettings ?? null)
                    @slot('titleFont', $titleFont ?? null)
                    @slot('hideShortDesc', $hideShortDesc ?? null)
                    @slot('gtmAttributes', $gtmAttributes ?? null)
                @endcomponent
            @endforeach
        @endcomponent
    @endif
@endcomponent
