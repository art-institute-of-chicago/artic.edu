@if (!empty($artworks))
    @component('components.molecules._m-title-bar')
        @slot('links', array(
            array('label' => 'Clear your history',
                'href' => route('artworks.clearRecentlyViewed'),
                'dataAttributes' => 'data-behavior="clearHistory" data-no-ajax'
            )
        ))
        Recently Viewed
    @endcomponent
    @component('components.atoms._hr')
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--scroll@medium o-grid-listing--scroll@large o-grid-listing--scroll@xlarge  o-grid-listing--gridlines-cols o-grid-listing--basic-artworks')
        @slot('cols_xsmall','4')
        @slot('cols_small','6')
        @slot('cols_medium','6')
        @slot('cols_large',(sizeof($artworks) > 6) ? '12' : '6')
        @slot('cols_xlarge',(sizeof($artworks) > 6) ? '12' : '6')
        @slot('behavior','dragScroll')
        @foreach ($artworks as $item)
            @component('components.molecules._m-listing----artwork-minimal')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'srcset' => array(200,400,600,800),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '100px',
                          'small' => '100px',
                          'medium' => '200px',
                          'large' => sizeof($artworks) > 6 ? 3 : 8,
                          'xlarge' => sizeof($artworks) > 6 ? 3 : 8,
                    )),
                ))
                @slot('gtmAttributes', 'data-gtm-event="recently-viewed" data-gtm-action="::document.title::" data-gtm-event-category="collection-nav"')
            @endcomponent
        @endforeach
    @endcomponent
@endif
