@extends('layouts.app')

@section('content')

@if ($mainFeatures->count() > 0)
    <div class="o-features">
        @component('components.organisms._o-feature')
            @slot('tag', 'div')
            @slot('item', $mainFeatures->first())
            @slot('isHero', true)
            @slot('gtmCount', 1)
        @endcomponent
    </div>
@endif

@if (!empty($hour))
    @component('components.organisms._o-hours')
        @slot('hour', $hour)
    @endcomponent
@endif

@if ($mainFeatures->count() > 1)
    <div class="o-features">
        @foreach ($mainFeatures->slice(1) as $key => $item)
            @component('components.organisms._o-feature')
                @slot('tag', 'div')
                @slot('item', $item)
                @slot('isHero', false)
                @slot('gtmCount', $key + 1)
            @endcomponent
        @endforeach
    </div>
@endif

@component('components.molecules._m-intro-block')
    @slot('links', array(
        array('label' => $visit_button_text, 'href' => $visit_button_url, 'variation' => 'btn', 'font' => 'f-buttons', 'gtmAttributes' => 'data-gtm-event="Visit" data-gtm-event-category="nav-cta-button"'),
        array('label' => SmartyPants::defaultTransform($plan_your_visit_link_1_text) .'<span aria-hidden="true">&nbsp;&nbsp;&rsaquo;</span>', 'href' => $plan_your_visit_link_1_url, 'gtmAttributes' => 'data-gtm-event="' . UrlHelpers::lastUrlSegment($plan_your_visit_link_1_url). '" data-gtm-event-category="nav-link"'),
        array('label' => SmartyPants::defaultTransform($plan_your_visit_link_2_text) .'<span aria-hidden="true">&nbsp;&nbsp;&rsaquo;</span>', 'href' => $plan_your_visit_link_2_url, 'gtmAttributes' => 'data-gtm-event="' . UrlHelpers::lastUrlSegment($plan_your_visit_link_2_url). '" data-gtm-event-category="nav-link"'),
        array('label' => SmartyPants::defaultTransform($plan_your_visit_link_3_text) .'<span aria-hidden="true">&nbsp;&nbsp;&rsaquo;</span>', 'href' => $plan_your_visit_link_3_url, 'gtmAttributes' => 'data-gtm-event="' . UrlHelpers::lastUrlSegment($plan_your_visit_link_3_url). '" data-gtm-event-category="nav-link"'),
    ))
    {!! SmartyPants::defaultTransform($intro) !!}
@endcomponent

@if ($exhibitions->count() > 0)
    @component('components.molecules._m-title-bar')
        @slot('links', array(
            array(
                'label' => 'All current exhibitions',
                'href' => $_pages['exhibitions'],
                'gtmAttributes' => 'data-gtm-event="home-exhibitions-and-events" data-gtm-event-category="nav-link"'
            ),
        ))
        Exhibitions
    @endcomponent

    @component('components.atoms._hr')
    @endcomponent

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
        @slot('cols_small','2')
        @slot('cols_medium','2')
        @slot('cols_large','2')
        @slot('cols_xlarge','2')
        @php ($count = 0)
        @foreach ($exhibitions as $item)
            @php ($count += 1)
            @component('components.molecules._m-listing----exhibition')
                @slot('titleFont', 'f-list-4')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600,1000,1500),
                    'sizes' => ImageHelpers::aic_gridListingImageSizes(array(
                          'xsmall' => '1',
                          'small' => '2',
                          'medium' => '2',
                          'large' => '2',
                          'xlarge' => '2',
                    )),
                ))
                @slot('gtmAttributes', 'data-gtm-event="' . $item->title . '" data-gtm-event-category="exhibition-' . $count . '"')
            @endcomponent
        @endforeach
    @endcomponent
@endif

@component('components.molecules._m-title-bar')
    @slot('links', array(
        array(
            'label' => 'See upcoming events',
            'href' => $_pages['events'],
            'gtmAttributes' => 'data-gtm-event="home-events" data-gtm-event-category="nav-link"'
        ),
    ))
    Events
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
                'sizes' => ImageHelpers::aic_gridListingImageSizes(array(
                      'xsmall' => '1',
                      'small' => '1',
                      'medium' => '4',
                      'large' => '4',
                      'xlarge' => '4',
                )),
            ))
            ))
            @slot('gtmAttributes', 'data-gtm-event="' . $item->title . '" data-gtm-event-category="nav-link"')
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
            'gtmAttributes' => 'data-gtm-event="home-exhibitions-and-events" data-gtm-event-category="nav-link"'
        ),
    ))
@endcomponent

@if ($videos->count() > 0)
    @component('components.organisms._o-gallery----slider')
        @slot('variation', 'o-gallery----theme-2')
        @slot('title', $video_title ?? 'Videos')
        @slot('caption', $video_description ?? null)
        @slot('allLink', null);
        @slot('imageSettings', array(
            'srcset' => array(200,400,600,1000,1500,3000),
            'sizes' => ImageHelpers::aic_imageSizes(array(
                  'xsmall' => '50',
                  'small' => '35',
                  'medium' => '23',
                  'large' => '23',
                  'xlarge' => '18',
            )),
        ))
        @php ($count = 0)
        @slot('items', $videos->map(function($item, $key) use ($seo, &$count) {
            $count += 1;
            $item->type = 'embed';
            $item->size = 'gallery';
            $item->restrict = false;
            $item->fullscreen = true;
            $item->poster = $item->imageAsArray('hero');
            $item->media = [
                'embed' => \App\Facades\EmbedConverterFacade::convertUrl($item->video_url),
            ];
            // Setting caption to empty string forces the title to be bolded
            $item->captionTitle = $item->present()->title_display ?? $item->present()->title;
            $item->caption = $item->list_description ?? '';
            $item->gtmAttributes = 'data-gtm-event="'. $item->captionTitle . '" data-gtm-event-category="video-' . ($count) . '"';

            return $item;
        }))
    @endcomponent
@endif

@component('components.atoms._hr')
    @slot('variation', 'u-show@small+')
@endcomponent

@component('components.molecules._m-cta-banner')
    @slot('image', $cta_module_image)
    @slot('href', $cta_module_action_url)
    @slot('header', $cta_module_header)
    @slot('body', $cta_module_body)
    @slot('button_text', $cta_module_button_text)
    @slot('gtmAttributes', 'data-gtm-event="'. $cta_module_button_text . '" data-gtm-event-category="internal-ad-click"')
@endcomponent


@if (isset($highlights) && $highlights->count() > 0)
    @component('components.molecules._m-title-bar')
        @slot('links',
            array(array('label' => 'See all highlights', 'href' => route('highlights.index'), 'gtmAttributes' => 'data-gtm-event="home-highlights" data-gtm-event-category="nav-link"'))
        )
        Highlights
    @endcomponent
    @component('components.atoms._hr')
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
        @slot('cols_small','2')
        @slot('cols_medium','3')
        @slot('cols_large','3')
        @slot('cols_xlarge','3')
        @foreach ($highlights as $k => $item)
            @component('components.molecules._m-listing----' . strtolower($item->type))
                @slot('variation', 'o-pinboard__item')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '1:1',
                    'srcset' => array(200,400,600,1000),
                    'sizes' => ImageHelpers::aic_gridListingImageSizes(array(
                        'xsmall' => '1',
                        'small' => '2',
                        'medium' => '3',
                        'large' => '3',
                        'xlarge' => '3',
                    )),
                ))
                @slot('gtmAttributes', 'data-gtm-event="' . $item->title . '" data-gtm-event-category="highlight-listing-' . ($loop->index + 1) . '"')
            @endcomponent
        @endforeach
    @endcomponent
@endif

@if (isset($homeArtists) && $homeArtists->count() > 0)
    @component('components.organisms._o-gallery----slider')
        @slot('variation', 'o-gallery----theme-2 o-gallery--artist')
        @slot('title', 'Artists')
        @slot('caption', null)
        @slot('allLink', null);
        @slot('imageSettings', array(
            'fit' => 'crop',
            'ratio' => '3:4',
            'srcset' => array(200,400,600,1000,1500,3000),
            'sizes' => ImageHelpers::aic_imageSizes(array(
                  'xsmall' => '42',
                  'small' => '23',
                  'medium' => '12',
                  'large' => '12',
                  'xlarge' => '12',
            )),
        ))
        @slot('items', $homeArtists->filter(function($item) {
            $artist = $item->apiModels('artists', 'Artist')->first();
            return ($item->imageFront('artist_image') ?? $artist->imageFront('hero')) !== null;
        })->map(function($item, $key) use ($seo) {
            $artist = $item->apiModels('artists', 'Artist')->first();
            if ($artist) {
                return [
                    'type' => 'artist',
                    'size' => 'gallery',
                    'media' => $item->imageFront('artist_image') ?? $artist->imageFront('hero'),
                    'captionTitle' => $artist->short_name_caption,
                    'caption' => $artist->short_name_display,
                    'href' => route('artists.show', $artist),
                    'gtmAttributes' => 'data-gtm-event="'. $artist->title . '" data-gtm-event-category="artist-listing-' . ($key + 1) . '"',
                ];
            }
            else {
                return [];
            }
        })->filter())
    @endcomponent
@endif


@if (isset($articles))
    @component('site.articles_publications._articleFeature')
        @slot('featureHero', $articles['featureHero'] ?? null)
        @slot('features', $articles['features'] ?? null)
    @endcomponent
@endif

@if (isset($artworks) && $artworks->count() > 0)
    @component('components.molecules._m-title-bar')
        @slot('links',
            array(array('label' => 'Explore the collection', 'href' => $_pages['collection'], 'gtmAttributes' => 'data-gtm-event="home-collection" data-gtm-event-category="nav-link"'))
        )
        Artworks
    @endcomponent
    @component('components.organisms._o-pinboard----artwork')
        @slot('artworks', $artworks)
        @slot('sizes', [
            'xsmall' => '1',
            'small' => '2',
            'medium' => '3',
            'large' => '3',
            'xlarge' => '3',
        ])
        @slot('gtmAttributesForItem', function($item, $loop) {
            return 'data-gtm-event="' . $item->title . '" data-gtm-event-category="collection-listing-' . ($loop->index + 1) . '"';
        })
    @endcomponent
@endif

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--title-bar-companion')
    @slot('linksPrimary', array(array('label' => 'Explore the collection', 'href' => $_pages['collection'], 'variation' => 'btn btn--secondary', 'gtmAttributes' => 'data-gtm-event="home-collection" data-gtm-event-category="nav-link"')))
@endcomponent

@if (isset($experiences) && $experiences->count() > 0)
    @component('site.articles_publications._interactiveFeature')
        @slot('experiences', $experiences)
    @endcomponent
@endif

@if (isset($products) && $products->count() > 0)
    @component('site.shared._featuredProducts')
        @slot('title', 'From the shop')
        @slot('titleLinks', [
            [
                'label' => 'Explore the shop',
                'href' => $_pages['shop'],
                'gtmAttributes' => 'data-gtm-event="home-shop" data-gtm-event-category="nav-link"'
            ]
        ])
        @slot('products', $products)
    @endcomponent
    @component('components.molecules._m-links-bar')
        @slot('variation', 'm-links-bar--title-bar-companion')
        @slot('linksPrimary', array(array('label' => 'Explore the shop', 'href' => $_pages['shop'], 'variation' => 'btn btn--secondary', 'gtmAttributes' => 'data-gtm-event="home-shop" data-gtm-event-category="nav-link"')))
    @endcomponent
@endif


<script type="application/ld+json">
{
        "@context": "http://schema.org",
        "@type": "TouristAttraction",
        "name": "The Art Institute of Chicago",
        "additionalType": "Museum, LandmarksOrHistoricalBuildings, LocalBusiness",
        "description": "{{ strip_tags($intro) }}",
        "url": "http://www.artic.edu/",
        "isAccessibleForFree": true
}
</script>

@endsection
