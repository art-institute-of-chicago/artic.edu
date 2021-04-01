@php
    $imageSettings = $imageSettings ?? array(
        'fit' => 'crop',
        'ratio' => '16:9',
        'srcset' => array(200,400,600),
        'sizes' => aic_imageSizes(array(
            'xsmall' => '58',
            'small' => '23',
            'medium' => '18',
            'large' => '13',
            'xlarge' => '13',
        )),
    );
@endphp

@if (isset($featuredRelated) && $featuredRelated)
    <aside class="m-inline-aside{{ (isset($variation)) ? ' '.$variation : '' }}">
        @component('components.atoms._hr')
        @endcomponent
        @component('components.blocks._text')
            @slot('font', 'f-module-title-1')
            @slot('tag', 'h4')
            Related Content
        @endcomponent
        @component('components.organisms._o-row-listing')
            @foreach ($featuredRelated as $related)
                @component('components.molecules._m-listing----' . strtolower($related['type']))
                    @slot('item', $related['item'])
                    @slot('fullscreen', false)
                    @slot('titleFont', 'f-list-1')
                    @slot('hideImage', $loop->index > 0)
                    @slot('hideDescription', $loop->index > 0)
                    @slot('imageSettings', $imageSettings ?? null)
                    @slot('gtmAttributes', 'data-gtm-event="related-sidebar" data-gtm-event-category="collection-nav"')
                @endcomponent
            @endforeach
        @endcomponent
    </aside>
@endif
