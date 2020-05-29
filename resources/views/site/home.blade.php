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
        array('label' => 'Visit us online', 'href' => $_pages['visit'], 'variation' => 'btn', 'font' => 'f-buttons', 'gtmAttributes' => 'data-gtm-event="Visit us online" data-gtm-event-action="' . $seo->title . '" data-gtm-event-category="nav-cta-button"'),
        array('label' => SmartyPants::defaultTransform($plan_your_visit_link_1_text) .'<span aria-hidden="true">&nbsp;&nbsp;&rsaquo;</span>', 'href' => $plan_your_visit_link_1_url),
        array('label' => SmartyPants::defaultTransform($plan_your_visit_link_2_text) .'<span aria-hidden="true">&nbsp;&nbsp;&rsaquo;</span>', 'href' => $plan_your_visit_link_2_url),
        array('label' => SmartyPants::defaultTransform($plan_your_visit_link_3_text) .'<span aria-hidden="true">&nbsp;&nbsp;&rsaquo;</span>', 'href' => $plan_your_visit_link_3_url),
    ))
    {!! SmartyPants::defaultTransform($intro) !!}
@endcomponent


@if ($videos->count() > 0)
    @component('components.organisms._o-gallery----slider')
        @slot('variation', 'o-gallery----theme-2')
        @slot('title', $video_title ?? 'Videos')
        @slot('caption', $video_description ?? null)
        @slot('allLink', null);
        @slot('imageSettings', array(
            'srcset' => array(200,400,600,1000,1500,3000),
            'sizes' => aic_imageSizes(array(
                  'xsmall' => '50',
                  'small' => '35',
                  'medium' => '23',
                  'large' => '23',
                  'xlarge' => '18',
            )),
        ))
        @slot('items', $videos->map(function($item, $key) use ($seo) {
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
            $item->gtmAttributes = 'data-gtm-event="'. $item->captionTitle . '" data-gtm-event-action="' . $seo->title . '" data-gtm-event-category="video-' . ($key) . '"';

            return $item;
        }))
    @endcomponent
@endif


{{-- Remove events from homepage during COVID-19 cancellations
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
--}}

@component('components.atoms._hr')
    @slot('variation', 'u-show@small+')
@endcomponent

@component('components.molecules._m-cta-banner----become-a-member')
    @slot('image', $cta_module_image)
    @slot('href', $cta_module_action_url)
    @slot('header', $cta_module_header)
    @slot('body', $cta_module_body)
    @slot('button_text', $cta_module_button_text)
    @slot('gtmAttributes', 'data-gtm-event="'. $cta_module_button_text . '" data-gtm-event-action="' . $seo->title . '" data-gtm-event-category="internal-ad-click"')
@endcomponent


@if ($highlights->count() > 0)
    @component('components.molecules._m-title-bar')
        @slot('links',
            array(array('label' => 'See all highlights', 'href' => route('selections.index'), 'gtmAttributes' => 'data-gtm-event="home-highlights" data-gtm-event-action="' . $seo->title . '"  data-gtm-event-category="nav-link"'))
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
                    'sizes' => aic_gridListingImageSizes(array(
                        'xsmall' => '1',
                        'small' => '2',
                        'medium' => '3',
                        'large' => '3',
                        'xlarge' => '3',
                    )),
                ))
                @slot('gtmAttributes', 'data-gtm-event="' . $item->type . '-' . $item->id . '-' . $item->trackingTitle . '" data-gtm-event-action="' . $seo->title . '"  data-gtm-event-category="highlight-listing-' . ($loop->index + 1) . '"')
            @endcomponent
        @endforeach
    @endcomponent
@endif

@if ($homeArtists->count() > 0)
    @component('components.organisms._o-gallery----slider')
        @slot('variation', 'o-gallery----theme-2 o-gallery--artist')
        @slot('title', 'Artists')
        @slot('caption', null)
        @slot('allLink', null);
        @slot('imageSettings', array(
            'fit' => 'crop',
            'ratio' => '3:4',
            'srcset' => array(200,400,600,1000,1500,3000),
            'sizes' => aic_imageSizes(array(
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
            return [
                'type' => 'artist',
                'size' => 'gallery',
                'media' => $item->imageFront('artist_image') ?? $artist->imageFront('hero'),
                'captionTitle' => $artist->short_name_display,
                'href' => route('artists.show', $artist),
                'gtmAttributes' => 'data-gtm-event="artist-'. $artist->datahub_id . '-' . $artist->short_name_display . '" data-gtm-event-action="' . $seo->title . '" data-gtm-event-category="artist-listing-' . ($key + 1) . '"',
            ];
        }))
    @endcomponent
@endif


@component('site.articles_publications._articleFeature')
    @slot('featureHero', $articles['featureHero'] ?? null)
    @slot('features', $articles['features'] ?? null)
@endcomponent


@if ($artworks->count() > 0)
    @component('components.molecules._m-title-bar')
        @slot('links',
            array(array('label' => 'Explore the collection', 'href' => $_pages['collection'], 'gtmAttributes' => 'data-gtm-event="home-collection" data-gtm-event-action="' . $seo->title . '"  data-gtm-event-category="nav-link"'))
        )
        Artworks
    @endcomponent
    @component('components.organisms._o-pinboard')
        @slot('cols_small','2')
        @slot('cols_medium','3')
        @slot('cols_large','3')
        @slot('cols_xlarge','3')
        @slot('maintainOrder','true')
        @foreach ($artworks as $k => $item)
            @component('components.molecules._m-listing----artwork')
                @slot('variation', 'o-pinboard__item')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'fit' => null,
                    'ratio' => null,
                    'srcset' => array(200,400,600,1000),
                    'sizes' => aic_gridListingImageSizes(array(
                        'xsmall' => '1',
                        'small' => '2',
                        'medium' => '3',
                        'large' => '3',
                        'xlarge' => '3',
                    )),
                ))
                @slot('gtmAttributes', 'data-gtm-event="artwork-' . $item->id . '-' . $item->trackingTitle . '" data-gtm-event-action="' . $seo->title . '"  data-gtm-event-category="collection-listing-' . ($loop->index + 1) . '"')
            @endcomponent
        @endforeach
    @endcomponent
@endif

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--title-bar-companion')
    @slot('linksPrimary', array(array('label' => 'Explore the collection', 'href' => $_pages['collection'], 'variation' => 'btn btn--secondary', 'gtmAttributes' => 'data-gtm-event="home-collection" data-gtm-event-action="' . $seo->title .'"  data-gtm-event-category="nav-link"')))
@endcomponent

@if ($experiences->count() > 0)
    @component('site.articles_publications._interactiveFeature')
        @slot('experiences', $experiences)
    @endcomponent
@endif

@if ($products->count() > 0)
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
