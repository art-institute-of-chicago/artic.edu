@php
    use App\Helpers\StringHelpers;

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
    $display = $block->input('display');
    $playlist = $block->getRelated('playlist')->first();
    $category = $block->getRelated('videoCategories')->first();
    $maxRows = (int) $block->input('max_rows') ?? 1;
    $take = $maxRows * (int) $width;
    switch ($display) {
        case 'category':
            $videos = $category->videos()->published()->get();
            $gridLinkLabel = "View all";
            $gridLinkHref = route('videos.archive', ['category' => $category->id]);
            break;
        case 'playlist':
            $videos = $playlist->videos()->published()->get();
            $gridLinkLabel = "View all";
            $gridLinkHref = route('playlists.show', ['playlist' => $playlist->id]);
            break;
        case 'featured':
            $videos = $block->getRelated('videos');
            break;
        default:
            $videos = [];
            break;
    }
    if (count($videos)) {
        $videos = $videos->take($take);
    }
    $showDescription = $block->input('show_description');
@endphp

@if($block->canRender())
<div class="o-grid-block video-grid">
    @component('components.molecules._m-title-bar')
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

    @component('components.organisms._o-grid-listing')
        @slot('behavior', 'dragScroll')
        @slot('cols_xsmall', $widthSmall)
        @slot('cols_small', $width)
        @slot('cols_medium', $width)
        @slot('cols_large', $width)
        @slot('cols_xlarge', $width)
        @foreach ($videos as $video)
            @component('components.molecules._m-listing----grid-item')
                @slot('url', $video->url ?? '')
                @slot('image', ['src' => $video->thumbnail_url ?? ''])
                @slot('label', $video->duration_display ?? '')
                @slot('labelPosition', 'overlay')
                @slot('title', $video->title ?? '')
                @slot('description', $showDescription ? StringHelpers::truncateStr($video->description) : '')
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
@endif
