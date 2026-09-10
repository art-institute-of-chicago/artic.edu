@if ($item->enclosedItem())
    @component('components.molecules._m-listing----' . strtolower($item->enclosedItem()->type))
        @slot('tag', $tag ?? null)
        @slot('item', $item->enclosedItem())
        @slot('isHero', $isHero)
        @slot('image', $item->enclosedItem()->featureImage)
        @slot('imageMobile', $item->enclosedItem()->featureImageMobile)
        @slot('variation', $isHero ? 'm-listing--hero' : 'm-listing--feature')
        @slot('titleFont', $isHero ? 'f-display-1' : 'f-list-4')
        @slot('imageSettings', array(
            'srcset' => array(200,400,600,843,1200,1686,3000),
            'sizes' => '100vw',
        ))
        @slot('gtmAttributes', 'data-gtm-event="'.StringHelpers::getUtf8Slug($item->enclosedItem()->title ?? 'unknown title').'" data-gtm-event-category="nav-hero-' . $gtmCount . '"')
    @endcomponent
@elseif ($item->url)
    @component('components.molecules._m-listing----custom')
        @slot('tag', $tag ?? null)
        @slot('item', $item)
        @slot('isHero', $isHero)
        @slot('image', $item->featureImage)
        @slot('imageMobile', $item->featureImageMobile)
        @slot('variation', $isHero ? 'm-listing--hero' : 'm-listing--feature')
        @slot('titleFont', $isHero ? 'f-display-1' : 'f-list-4')
        @slot('imageSettings', array(
            'srcset' => array(200,400,600,843,1200,1686,3000),
            'sizes' => '100vw',
        ))
        @slot('gtmAttributes', 'data-gtm-event="'.(UrlHelpers::lastUrlSegment($item->url) ?? 'unknown title').'" data-gtm-event-category="nav-hero-' . $gtmCount . '"')
    @endcomponent
@endif
