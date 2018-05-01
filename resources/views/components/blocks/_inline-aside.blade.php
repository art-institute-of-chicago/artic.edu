@component('components.molecules._m-inline-aside')
    @slot('variation', $variation ?? null)
    @if (sizeof($items) === 1)
        @slot('title', 'Related '.ucfirst($type))
        @component('components.molecules.'.$itemsMolecule)
            @slot('tag', 'p')
            @slot('variation', $itemsVariation ?? null)
            @slot('item', $items[0])
            @slot('fullscreen', false)
            @slot('imageSettings', $imageSettings ?? null)
            @slot('titleFont', $titleFont ?? null)
            @slot('hideShortDesc', $hideShortDesc ?? null)
        @endcomponent
    @else
        @slot('title', 'Related '.ucfirst($type).'s')
        @component('components.organisms._o-row-listing')
            @foreach ($items as $item)
                @component('components.molecules.'.$itemsMolecule)
                    @slot('variation', $itemsVariation ?? null)
                    @slot('item', $item)
                    @slot('fullscreen', false)
                    @slot('imageSettings', $imageSettings ?? null)
                    @slot('titleFont', $titleFont ?? null)
                    @slot('hideShortDesc', $hideShortDesc ?? null)
                @endcomponent
            @endforeach
        @endcomponent
    @endif
@endcomponent
