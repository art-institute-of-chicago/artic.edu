@extends('layouts.app')

@section('content')

    <article>
        <header>
            @component('components.molecules._m-header-block')
                @slot('tag', 'div')
                {{ $title }}
            @endcomponent

            @component('components.molecules._m-intro-block')
                @slot('variation', 'm-intro-block--tight')
                {!! $intro !!}
            @endcomponent
        </header>

        @component('components.molecules._m-links-bar')
            @slot('variation', 'm-links-bar--tabs')
            @slot('overflow', true)
            @slot('linksPrimary', $linksBar)
        @endcomponent
        
        <section>
            @component('components.molecules._m-title-bar')
                @slot('variation', 'm-title-bar--no-hr')
                @slot('links', array(array('label' => 'Browse all digital publications', 'href' => route('collection.publications.digital-publications'))))
                Digital Publications
            @endcomponent

            @component('components.atoms._hr')
            @endcomponent

            @component('components.organisms._o-grid-listing')
                @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
                @slot('cols_large','3')
                @slot('cols_xlarge','3')
                @foreach ($digitalPublications['items'] as $item)
                    @component('components.molecules._m-listing----generic')
                        @slot('variation', 'm-listing--row@small m-listing--row@medium')
                        @slot('item', $item)
                        @slot('image', $item->imageFront('listing') ?? null)
                        @slot('imageSettings', array(
                            'fit' => 'crop',
                            'ratio' => '16:9',
                            'srcset' => array(200,400,600),
                            'sizes' => ImageHelpers::aic_imageSizes(array(
                                  'xsmall' => '58',
                                  'small' => '23',
                                  'medium' => '22',
                                  'large' => '18',
                                  'xlarge' => '18',
                            )),
                        ))
                    @endcomponent
                @endforeach
            @endcomponent

            @component('components.molecules._m-links-bar')
                @slot('variation', 'm-links-bar--title-bar-companion')
                @slot('linksPrimary', array(
                    array(
                        'label' => 'Browse all digital publications',
                        'href' => route('collection.publications.digital-publications'),
                        'variation' => 'btn btn--secondary'
                    ),
                ))
            @endcomponent
        </section>

        <section>
            @component('components.molecules._m-title-bar')
                @slot('links', array(array('label' => 'Browse all print publications', 'href' => route('collection.publications.printed-publications'))))
                Print Publications
            @endcomponent

            @if (!empty($printedPublications['intro']))
                @component('components.atoms._hr')
                @endcomponent

                @component('components.molecules._m-intro-block')
                    {!! $printedPublications['intro'] !!}
                @endcomponent
            @endif

            @component('components.atoms._hr')
            @endcomponent

            @component('components.organisms._o-grid-listing')
                @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
                @slot('cols_large','3')
                @slot('cols_xlarge','3')
                @foreach ($printedPublications['items'] as $item)
                    @component('components.molecules._m-listing----generic')
                        @slot('variation', 'm-listing--row@small m-listing--row@medium')
                        @slot('item', $item)
                        @slot('image', $item->imageFront('listing') ?? null)
                        @slot('imageSettings', array(
                            'fit' => 'crop',
                            'ratio' => '16:9',
                            'srcset' => array(200,400,600),
                            'sizes' => ImageHelpers::aic_imageSizes(array(
                                  'xsmall' => '58',
                                  'small' => '23',
                                  'medium' => '22',
                                  'large' => '13',
                                  'xlarge' => '13',
                            )),
                        ))
                    @endcomponent
                @endforeach
            @endcomponent

            @component('components.molecules._m-links-bar')
                @slot('variation', 'm-links-bar--title-bar-companion')
                @slot('linksPrimary', array(
                    array(
                        'label' => 'Browse all print publications',
                        'href' => route('collection.publications.printed-publications'),
                        'variation' => 'btn btn--secondary'
                    ),
                ))
            @endcomponent
        </section>

@endsection
