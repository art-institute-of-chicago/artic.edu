@extends('layouts.app')

@section('content')

<article itemscope itemtype="http://schema.org/Person">
    @component('site.shared._schemaItemProps')
      @slot('itemprops',$item->present()->itemprops ?? null)
    @endcomponent

@component('components.molecules._m-header-block')
    @slot('itemprop','name')
    {!! $item->present()->title_display ?? $item->present()->title !!}
@endcomponent

    @component('components.organisms._o-artist-bio')
        @slot('item', $item)
        @slot('imageSettings', array(
            'srcset' => array(200,400,600,1000,1500,2000),
            'sizes' => ImageHelpers::aic_imageSizes(array(
                  'xsmall' => '58',
                  'small' => '58',
                  'medium' => '58',
                  'large' => '28',
                  'xlarge' => '28',
            )),
        ))
    @endcomponent

</article>

@unless ($artworks->isEmpty())
    @component('components.molecules._m-title-bar')
        @slot('links', [
            [
                'label' => "See all {$artworks->total()} artworks",
                'href'  => $item->present()->collectionFilteredUrl,
            ]
        ])
        {{ $item->getAugmentedModel()->pinboard_title ?? 'Artworks' }}
    @endcomponent

    @component('components.organisms._o-pinboard----artwork')
        @slot('artworks', $artworks)
        @slot('sizes', [
            'xsmall' => '1',
            'small' => '2',
            'medium' => '3',
            'large' => '4',
            'xlarge' => '4',
        ])
    @endcomponent
@endunless

@if ($artworks->total() > 8)
    @component('components.molecules._m-links-bar')
        @slot('variation', 'm-links-bar--buttons')
        @slot('linksPrimary', array(
            [
                'label' => "See all {$artworks->total()} artworks",
                'href'  => $item->present()->collectionFilteredUrl,
                'variation' => 'btn--secondary'
            ]
        ));
    @endcomponent
@endif

@if (isset($relatedItems))
    @component('components.molecules._m-title-bar')
        Related Content
    @endcomponent
    @component('components.atoms._hr')
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
        @slot('cols_small','2')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @foreach ($relatedItems as $item)
            @component('components.molecules._m-listing----' . (strtolower($item->type ?? 'article')))
                @slot('item', $item)
                @slot('hideImage', false)
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
@endif

@if (isset($exploreFurther))
<div id="exploreFurther">
    @component('components.molecules._m-title-bar')
        Explore Further
    @endcomponent

    @component('site.shared._explore-further-menu')
        @slot('tags', $exploreFurtherTags)
    @endcomponent

    @if ($exploreFurther && !$exploreFurther->isEmpty())
        @component('site.shared._exploreFurther')
            @slot('artworks', $exploreFurther)
        @endcomponent
    @endif

    @if ($exploreFurtherCollectionUrl)
        @component('components.molecules._m-links-bar')
            @slot('variation', 'm-links-bar--buttons')
            @slot('linksPrimary', [
                [
                    'label' => 'See more results',
                    'href' => $exploreFurtherCollectionUrl,
                    'variation' => 'btn--tertiary'
                ]
            ])
        @endcomponent
    @endif
</div>
@endif

@if (isset($item->exhibitions))
    @component('components.molecules._m-title-bar')
        Exhibitions
    @endcomponent

    @component('components.atoms._hr')
    @endcomponent

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
        @slot('cols_small','2')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @foreach ($item->exhibitions as $item)
            @component('components.molecules._m-listing----exhibition')
                @slot('item', $item)
            @endcomponent
        @endforeach
    @endcomponent
@endif

<div class="o-injected-container" data-behavior="injectContent" data-injectContent-url="{!! route('artworks.recentlyViewed') !!}" data-user-artwork-history></div>

@endsection
