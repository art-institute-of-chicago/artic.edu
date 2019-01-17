@extends('layouts.app')

@section('content')
    <section class="o-closer-look" data-behavior="closerLook">
        <script type="application/json" data-closerLook-contentBundle>
            <?php echo json_decode($item->content_bundle)->contentBundle; ?>
        </script>
        <script type="application/json" data-closerLook-assetLibrary>
            <?php echo json_decode($item->asset_library)->assetLibraryData; ?>
        </script>
    </section>

    <section>
        @component('components.molecules._m-title-bar')
            Further Reading
        @endcomponent
        @component('components.organisms._o-grid-listing')
            @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows')
            @slot('cols_medium','3')
            @slot('cols_large','4')
            @slot('cols_xlarge','4')
            @slot('behavior','dragScroll')
            @foreach ($furtherReading as $item)
                @component('components.molecules._m-listing----article')
                    @slot('item', $item)
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
            @endforeach
        @endcomponent
    </section>

@endsection
