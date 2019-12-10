@extends('layouts.app')

@section('content')

@component('components.organisms._o-features')
     @php ($countMain = 0)
    @foreach ($mainFeatures as $key => $item)
        @php ($countMain = $countMain + 1)
        @if ($item->enclosedItem())
            @component('components.molecules._m-listing----' . strtolower($item->enclosedItem()->type))
                @slot('item', $item->enclosedItem())
                @slot('image', $item->enclosedItem()->featureImage)
                @slot('variation', ($loop->first) ? 'm-listing--hero' : 'm-listing--feature')
                @slot('titleFont', ($loop->first) ? 'f-display-1' : 'f-list-4')
                @slot('imageSettings', array(
                    'srcset' => array(300,600,1000,1500,3000),
                    'sizes' => '100vw',
                ))
                @slot('gtmAttributes', ($loop->first) ? 'data-gtm-event="'.getUtf8Slug($item->enclosedItem()->title ?? 'unknown title').'"  data-gtm-event-action="' . $seo->title . '" data-gtm-event-category="nav-hero-' . $countMain . '"' : 'data-gtm-event="'.getUtf8Slug($item->enclosedItem()->title ?? 'unknown title').'" data-gtm-event-action="' . $seo->title . '"  data-gtm-event-category="nav-hero-' . $countMain . '"')
            @endcomponent
        @elseif ($item->url)
            @component('components.molecules._m-listing----custom')
                @slot('item', $item)
                @slot('image', $item->featureImage)
                @slot('variation', ($loop->first) ? 'm-listing--hero' : 'm-listing--feature')
                @slot('titleFont', ($loop->first) ? 'f-display-1' : 'f-list-4')
                @slot('imageSettings', array(
                    'srcset' => array(300,600,1000,1500,3000),
                    'sizes' => '100vw',
                ))
                @slot('gtmAttributes', ($loop->first) ? 'data-gtm-event="'.getUtf8Slug($item->enclosedItem()->title ?? 'unknown title').'"  data-gtm-event-action="' . $seo->title . '" data-gtm-event-category="nav-hero-' . $countMain . '"' : 'data-gtm-event="'.getUtf8Slug($item->enclosedItem()->title ?? 'unknown title').'" data-gtm-event-action="' . $seo->title . '"  data-gtm-event-category="nav-hero-' . $countMain . '"')
            @endcomponent
        @endif
    @endforeach
@endcomponent

@component('components.molecules._m-intro-block')
    @slot('links', array(
        array('label' => 'Plan your visit', 'href' => $_pages['visit'], 'variation' => 'btn', 'font' => 'f-buttons', 'gtmAttributes' => 'data-gtm-event="Plan your visit" data-gtm-event-action="' . $seo->title . '" data-gtm-event-category="nav-cta-button"'),
        array('label' => SmartyPants::defaultTransform($plan_your_visit_link_1_text) .'<span aria-hidden="true">&nbsp;&nbsp;&rsaquo;</span>', 'href' => $plan_your_visit_link_1_url),
        array('label' => SmartyPants::defaultTransform($plan_your_visit_link_2_text) .'<span aria-hidden="true">&nbsp;&nbsp;&rsaquo;</span>', 'href' => $plan_your_visit_link_2_url),
        array('label' => SmartyPants::defaultTransform($plan_your_visit_link_3_text) .'<span aria-hidden="true">&nbsp;&nbsp;&rsaquo;</span>', 'href' => $plan_your_visit_link_3_url),
    ))
    {!! SmartyPants::defaultTransform($intro) !!}
@endcomponent

@component('components.molecules._m-title-bar')
    @slot('links', array(
        array(
            'label' => 'All current exhibitions and events',
            'href' => $_pages['exhibitions'],
            'gtmAttributes' => 'data-gtm-event="home-exhibitions-and-events" data-gtm-event-action="' . $seo->title . '"  data-gtm-event-category="nav-link"'
        ),
    ))
    Exhibitions and Events
@endcomponent

@component('components.atoms._hr')
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
    @slot('cols_small','2')
    @slot('cols_medium','2')
    @slot('cols_large','2')
    @slot('cols_xlarge','2')
    @foreach ($exhibitions as $item)
        @component('components.molecules._m-listing----exhibition')
            @slot('titleFont', 'f-list-4')
            @slot('item', $item)
            @slot('imageSettings', array(
                'fit' => 'crop',
                'ratio' => '16:9',
                'srcset' => array(200,400,600,1000,1500),
                'sizes' => aic_gridListingImageSizes(array(
                      'xsmall' => '1',
                      'small' => '2',
                      'medium' => '2',
                      'large' => '2',
                      'xlarge' => '2',
                )),
            ))
            @slot('gtmAttributes', 'data-gtm-event="' . $item->title . '" data-gtm-event-action="' . $seo->title . '"  data-gtm-event-category="nav-link"')
        @endcomponent
    @endforeach
@endcomponent

@component('components.atoms._hr')
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
    @slot('cols_small','2')
    @slot('cols_medium','4')
    @slot('cols_large','4')
    @slot('cols_xlarge','4')
    @foreach ($events as $item)
        @component('components.molecules._m-listing----event')
            @slot('item', $item)
            @slot('imageSettings', array(
                'fit' => 'crop',
                'ratio' => '16:9',
                'srcset' => array(200,400,600),
                'sizes' => aic_gridListingImageSizes(array(
                      'xsmall' => '1',
                      'small' => '1',
                      'medium' => '4',
                      'large' => '4',
                      'xlarge' => '4',
                )),
            ))
            ))
            @slot('gtmAttributes', 'data-gtm-event="' . $item->title . '" data-gtm-event-action="' . $seo->title . '"  data-gtm-event-category="nav-link"')
        @endcomponent
    @endforeach
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--title-bar-companion')
    @slot('linksPrimary', array(
        array(
            'label' => 'All current exhibitions and events',
            'href' => $_pages['exhibitions'],
            'variation' => 'btn btn--secondary',
            'gtmAttributes' => 'data-gtm-event="home-exhibitions-and-events" data-gtm-event-action="' . $seo->title . '"  data-gtm-event-category="nav-link"'
        ),
    ))
@endcomponent

@component('components.atoms._hr')
    @slot('variation', 'u-show@small+')
@endcomponent

@component('components.molecules._m-cta-banner----become-a-member')
    @slot('image', $membership_module_image)
    @slot('href', $membership_module_url)
    @slot('headline', $membership_module_headline)
    @slot('short_copy', $membership_module_short_copy)
    @slot('button_text', $membership_module_button_text)
    @slot('gtmAttributes', 'data-gtm-event="'. $membership_module_button_text . '" data-gtm-event-action="' . $seo->title . '" data-gtm-event-category="internal-ad-click"')
@endcomponent


@component('components.molecules._m-title-bar')
    @slot('links',
        array(array('label' => 'Explore the collection', 'href' => $_pages['collection'], 'gtmAttributes' => 'data-gtm-event="home-collection" data-gtm-event-action="' . $seo->title . '"  data-gtm-event-category="nav-link"'))
    )
    From the Collection
@endcomponent
@php($countCollection = 0)
@component('components.organisms._o-pinboard')
    @slot('cols_small','2')
    @slot('cols_medium','3')
    @slot('cols_large','3')
    @slot('cols_xlarge','3')
    @slot('maintainOrder','true')
    @foreach ($theCollection as $k => $item)
    @php($countCollection = $countCollection+1)
        @if ($item->enclosedItem())
            @component('components.molecules._m-listing----' . strtolower($item->enclosedItem()->type))
                @slot('variation', 'o-pinboard__item')
                @slot('item', $item->enclosedItem())
                @slot('imageSettings', array(
                    'fit' => ($item->enclosedItem()->type !== 'artwork') ? 'crop' : null,
                    'ratio' => ($item->enclosedItem()->type === 'selection') ? '1:1' : (
                        ($item->enclosedItem()->type === 'artwork') ? null : '16:9'
                    ),
                    'srcset' => array(200,400,600,1000),
                    'sizes' => aic_gridListingImageSizes(array(
                          'xsmall' => '1',
                          'small' => '2',
                          'medium' => '3',
                          'large' => '3',
                          'xlarge' => '3',
                    )),
                ))
                @slot('gtmAttributes', 'data-gtm-event="' . $item->enclosedItem()->type . '-' . $item->enclosedItem()->id . '-' . $item->enclosedItem()->trackingTitle . '" data-gtm-event-action="' . $seo->title . '"  data-gtm-event-category="collection-listing-' . $countCollection . '"')
            @endcomponent
        @endif
    @endforeach
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--title-bar-companion')
    @slot('linksPrimary', array(array('label' => 'Explore the collection', 'href' => $_pages['collection'], 'variation' => 'btn btn--secondary', 'gtmAttributes' => 'data-gtm-event="home-collection" data-gtm-event-action="' . $seo->title .'"  data-gtm-event-category="nav-link"')))
@endcomponent

@component('site.shared._featuredProducts')
    @slot('title', 'From the shop')
    @slot('titleLinks', [
        [
            'label' => 'Explore the shop',
            'href' => $_pages['shop'],
            'gtmAttributes' => 'data-gtm-event="home-shop" data-gtm-event-action="' . $seo->title . '"  data-gtm-event-category="nav-link"'
        ]
    ])
    @slot('products', $products)
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--title-bar-companion')
    @slot('linksPrimary', array(array('label' => 'Explore the shop', 'href' => $_pages['shop'], 'variation' => 'btn btn--secondary', 'gtmAttributes' => 'data-gtm-event="home-shop" data-gtm-event-action="' . $seo->title . '"  data-gtm-event-category="nav-link"')))
@endcomponent

<script type="application/ld+json">
{
        "@context": "http://schema.org",
        "@type": "TouristAttraction",
        "name": "The Art Institute of Chicago",
        "additionalType": "Museum, LandmarksOrHistoricalBuildings, LocalBusiness",
        "description": '{{ strip_tags($intro) }}',
        "url": "http://www.artic.edu/",
        "isAccessibleForFree": true
}
</script>

@endsection
