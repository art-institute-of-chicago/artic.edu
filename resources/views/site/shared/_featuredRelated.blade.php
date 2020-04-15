@if (isset($featuredRelated) && $featuredRelated)
    @foreach ($featuredRelated as $related)
        @component('components.blocks._inline-aside')
            @slot('variation', $variation ?? null)
            @slot('type', $related['label'] ?? null)
            @slot('items', $related['items'])
            @slot('titleFont', 'f-list-1')
            @slot('itemsMolecule', '_m-listing----'.strtolower($related['type']))
            @slot('imageSettings', array(
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
            ))
            @slot('gtmAttributes', 'data-gtm-event="related-sidebar" data-gtm-event-category="collection-nav"')
        @endcomponent
    @endforeach
@endif
