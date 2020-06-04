@php
    use App\Models\MagazineItem;

    $featureType = $block->input('feature_type');
    $isBlockReady = false;

    if ($featureType !== MagazineItem::ITEM_TYPE_CUSTOM) {
        $ids = $block->browserIds($featureType);
        $item = MagazineItem::findByType($featureType, $ids);

        if ($item) {
            $href = $item->url;
            $image = $item->imageFront('hero');
            $type = $item->present()->type;
            $title = $item->present()->title;
            $title_display = $item->present()->title_display;
            $list_description = $block->input('list_description') ?? $item->present()->list_description;
            $author_display = $item->author_display;

            $isBlockReady = true;
        }
    } else {
        $image = $block->imageAsArray('listing_image', 'default');
        $type = $block->input('tag');
        $title = $block->input('title');
        $title_display = null;
        $list_description = $block->input('list_description');
        $author_display = $block->input('author_display');

        $isBlockReady = true;
    }
@endphp

@if ($isBlockReady)
    @component('components.molecules._m-listing----publication')
        @slot('variation', 'm-listing--magazine')
        @slot('href', $href ?? null)
        @slot('image', $image ?? null)
        @slot('type', $type ?? null)
        @slot('title', $title ?? null)
        @slot('title_display', $title_display ?? null)
        @slot('list_description', $list_description ?? null)
        @slot('author_display', $author_display ?? null)
        @slot('imageSettings', array(
            'fit' => 'crop',
            'ratio' => '16:9',
            'srcset' => array(200,400,600),
            'sizes' => aic_imageSizes(array(
                  'xsmall' => '216px',
                  'small' => '216px',
                  'medium' => '18',
                  'large' => '13',
                  'xlarge' => '13',
            )),
        ))
    @endcomponent
@endif
