@extends('layouts.app')

@section('content')

<article itemscope itemtype="http://schema.org/Person">
    @component('site.shared._schemaItemProps')
      @slot('itemprops',$item->present()->itemprops ?? null)
    @endcomponent

    @component('components.molecules._m-header-block')
        @slot('itemprop','name')
        @slot('breadcrumbs', $breadcrumbs)
        {!! $item->present()->title_display ?? $item->present()->title !!}
    @endcomponent

    @component('components.organisms._o-artist-bio')
        @slot('item', $item)
        @slot('variation', 'author')
        @slot('imageSettings', array(
            'monochrome' => true,
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

    @if ($item->present()->getRelatedWritings())
        @component('components.organisms._o-grid-listing')
            @slot('variation', 'o-grid-listing--journal')
            @slot('cols_xsmall','1')
            @slot('cols_small','2')
            @slot('cols_medium','2')
            @slot('cols_large','2')
            @slot('cols_xlarge','2')
            @foreach ($item->present()->getRelatedWritings() as $item)
                @component('components.molecules._m-listing----publication')
                    @slot('variation', 'm-listing--author')
                    @slot('href', $item->present()->url)
                    @slot('image', $item->imageFront('hero'))
                    @slot('type', $item->present()->type)
                    @slot('title', $item->present()->title)
                    @slot('title_display', $item->present()->title_display)
                    @slot('list_description', $item->present()->list_description)
                    @slot('author_display', $item->showAuthors())
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
</article>

@endsection
