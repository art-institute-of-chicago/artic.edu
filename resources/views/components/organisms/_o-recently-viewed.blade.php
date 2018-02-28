@if (!empty($artworks))
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'Clear your history', 'href' => '#')))
        Recently Viewed
    @endcomponent
    @component('components.atoms._hr')
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--scroll@medium o-grid-listing--scroll@large o-grid-listing--scroll@xlarge  o-grid-listing--gridlines-cols')
        @slot('cols_large',(sizeof($artworks) > 6) ? '12' : '6')
        @slot('cols_xlarge',(sizeof($artworks) > 6) ? '12' : '6')
        @slot('behavior','dragScroll')
        @foreach ($artworks as $item)
            @component('components.molecules._m-listing----artwork-minimal')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'srcset' => array(108,216,400,600),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '216px',
                          'small' => '216px',
                          'medium' => '216px',
                          'large' => sizeof($artworks) > 6 ? 3 : 8,
                          'xlarge' => sizeof($artworks) > 6 ? 3 : 8,
                    )),
                ))
            @endcomponent
        @endforeach
    @endcomponent
    @component('components.atoms._hr')
        @slot('variation','hr--flush-topp')
    @endcomponent
@endif
