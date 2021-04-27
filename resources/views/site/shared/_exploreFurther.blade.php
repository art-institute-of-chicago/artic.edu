@component('components.organisms._o-pinboard----artwork')
    @slot('id', 'explore-further-pinboard')
    @slot('title', 'Related artworks')
    @slot('artworks', $artworks ?? null)
    @slot('sizes', [
        'xsmall' => '1',
        'small' => '2',
        'medium' => '3',
        'large' => '4',
        'xlarge' => '4',
    ])
@endcomponent
