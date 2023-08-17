@if($headerMedia['style'] != 'feature')
    @component('components.molecules._m-media')
        @slot('item', $headerMedia)
        @slot('tag', 'span')
        @slot('imageSettings', array(
            'srcset' => array(300,600,1000,1500,3000),
            'sizes' => '100vw',
        ))
        @slot('variation', 'm-visit-header')
    @endcomponent
@endif