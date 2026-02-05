@php
    $gridTitle = $block->present()->input('heading');
    $gridDescription = $block->input('description');
    $gridLinkLabel = $block->input('grid_link_label');
    $gridLinkHref = $block->input('grid_link_href');
    $variation = $block->input('variation');
    $widthSmall = '1';
    switch ($variation) {
        case '4-wide':
            $width = '4';
            break;
        case '2-wide':
            $width = '2';
            break;
        case '3-wide':
        default:
            $width = '3';
            break;
    }
    $playlists = $block->getRelated('playlists');
@endphp

<div class="o-grid-block playlist-grid">
    @component('components.molecules._m-title-bar')
        @slot('id', 'playlists')
        @slot('links', !empty($gridLinkLabel) && !empty($gridLinkHref) ? [
            [
                'label' => $gridLinkLabel,
                'href'  => $gridLinkHref,
                'id' => Str::slug(strip_tags($gridTitle)),
            ]
        ] : null)
        @if (!empty($gridTitle))
            {!!'<span class="o-grid-block__title">'. $gridTitle .'</span>'!!}
        @endif
        @if (!empty($gridDescription))
            {!!'<span class="o-grid-block__description">'. $gridDescription .'</span>'!!}
        @endif
    @endcomponent

    <span class="o-grid-block__subtitle">Playlists</span>

    @component('components.organisms._o-grid-listing')
        @slot('behavior', 'dragScroll')
        @slot('cols_xsmall', $widthSmall)
        @slot('cols_small', $width)
        @slot('cols_medium', $width)
        @slot('cols_large', $width)
        @slot('cols_xlarge', $width)
        @foreach ($playlists as $playlist)
            @php
                $playlistThumbnails = $playlist->videos()
                    ->wherePivot('position', '>', 0)  // The first video thumbnail is the same as the playlist thumbnail
                    ->get()
                    ->take(2)
                    ->map(fn($video) => ImageHelpers::youtubeItemAsArray($video));
                $videoCount = $playlist->videos()->count();
            @endphp
            @component('components.molecules._m-listing----playlist-grid-item')
                @slot('url', route('playlists.show', ['playlist' => $playlist]))
                @slot('image', ImageHelpers::youtubeItemAsArray($playlist))
                @slot('images', $playlistThumbnails)
                @slot('label', "$videoCount videos")
                @slot('labelPosition', 'overlay')
                @slot('title', $playlist->title)
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600),
                    'sizes' => ImageHelpers::aic_imageSizes(array(
                          'xsmall' => '216px',
                          'small' => '216px',
                          'medium' => '18',
                          'large' => '13',
                          'xlarge' => '13',
                    )),
                ))
            @endcomponent
        @endforeach
    @endcomponent
</div>
