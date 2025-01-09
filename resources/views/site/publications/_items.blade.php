@php
    use App\Helpers\GtmHelpers;
@endphp

@foreach ($publications as $item)
    @component('components.molecules._m-listing----publication')
        @slot('href', $item->present()->url)
        @slot('image', $item->imageFront('listing'))
        @slot('type', $item->present()->type)
        @slot('title', $item->present()->title)
        @slot('title_display', $item->present()->title_display)
        @slot('list_description', $item->present()->list_description)
        @slot('author_display', '')
        @slot('imageSettings', array(
            'fit' => null,
            'ratio' => null,
            'srcset' => array(200,400,600,1000,1500),
            'sizes' => ImageHelpers::aic_imageSizes(array(
                'xsmall' => '58',
                'small' => '58',
                'medium' => '38',
                'large' => '28',
                'xlarge' => '28',
            )),
        ))
        @slot('gtmAttributes', GtmHelpers::combineGtmAttributes([
            GtmHelpers::getGtmAttributesForClickMetaDataEventOnArtwork($item),
            'data-gtm-event="' . $item->title . '" data-gtm-event-category="publication-landing"',
        ]))
    @endcomponent
@endforeach
