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
                @slot('links', array(array('label' => 'Browse all articles', 'href' => route('articles'))))
                @slot('variation', 'm-title-bar--no-hr')
                Art Institute Blog
            @endcomponent

            @component('components.atoms._hr')
            @endcomponent

            <div class="o-feature-plus-4">
                @if ($featureHero)
                @component('components.molecules._m-listing----article')
                    @slot('tag', 'p')
                    @slot('titleFont', 'f-headline-editorial')
                    @slot('captionFont', 'f-body-editorial')
                    @slot('variation', 'o-feature-plus-4__feature')
                    @slot('item', $featureHero)
                    @slot('imageSettings', array(
                        'fit' => 'crop',
                        'ratio' => '16:9',
                        'srcset' => array(200,400,600,1000),
                        'sizes' => aic_imageSizes(array(
                              'xsmall' => '58',
                              'small' => '58',
                              'medium' => '38',
                              'large' => '28',
                              'xlarge' => '28',
                        )),
                    ))
                @endcomponent
                @endif

                <ul class="o-feature-plus-4__items-1">
                @foreach ($features as $editorial)
                    @if ($loop->index < 2)
                        @component('components.molecules._m-listing----article-minimal')
                            @slot('item', $editorial)
                            @slot('imageSettings', array(
                                'fit' => 'crop',
                                'ratio' => '16:9',
                                'srcset' => array(200,400,600),
                                'sizes' => aic_imageSizes(array(
                                      'xsmall' => '58',
                                      'small' => '28',
                                      'medium' => '18',
                                      'large' => '13',
                                      'xlarge' => '13',
                                )),
                            ))
                        @endcomponent
                    @endif
                @endforeach
                </ul>
                <ul class="o-feature-plus-4__items-2">
                @foreach ($features as $editorial)
                    @if ($loop->index > 1)
                        @component('components.molecules._m-listing----article-minimal')
                            @slot('item', $editorial)
                            @slot('imageSettings', array(
                                'fit' => 'crop',
                                'ratio' => '16:9',
                                'srcset' => array(200,400,600),
                                'sizes' => aic_imageSizes(array(
                                      'xsmall' => '58',
                                      'small' => '28',
                                      'medium' => '18',
                                      'large' => '13',
                                      'xlarge' => '13',
                                )),
                            ))
                        @endcomponent
                    @endif
                @endforeach
                </ul>
            </div>

            @component('components.molecules._m-links-bar')
                @slot('variation', 'm-links-bar--title-bar-companion')
                @slot('linksPrimary', array(
                    array(
                        'label' => 'Browse all articles',
                        'href' => route('articles'),
                        'variation' => 'btn btn--secondary'
                    ),
                ))
            @endcomponent
        </section>

        <section>
            @component('components.molecules._m-title-bar')
                @slot('links', array(array('label' => 'Browse all digital catalogs', 'href' => route('collection.publications.digital-catalogs'))))
                Digital Catalogs
            @endcomponent

            @component('components.atoms._hr')
            @endcomponent

            @component('components.organisms._o-grid-listing')
                @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
                @slot('cols_large','3')
                @slot('cols_xlarge','3')
                @foreach ($digitalCatalogs['items'] as $item)
                    @component('components.molecules._m-listing----generic')
                        @slot('variation', 'm-listing--row@small m-listing--row@medium')
                        @slot('item', $item)
                        @slot('image', $item->imageFront('listing') ?? null)
                        @slot('imageSettings', array(
                            'fit' => 'crop',
                            'ratio' => '16:9',
                            'srcset' => array(200,400,600),
                            'sizes' => aic_imageSizes(array(
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
                        'label' => 'Browse all digital catalogs',
                        'href' => route('collection.publications.digital-catalogs'),
                        'variation' => 'btn btn--secondary'
                    ),
                ))
            @endcomponent
        </section>

        <section>
            @component('components.molecules._m-title-bar')
                @slot('links', array(array('label' => 'Browse all printed catalogs', 'href' => route('collection.publications.printed-catalogs'))))
                Printed Catalogs
            @endcomponent

            @component('components.atoms._hr')
            @endcomponent

            @component('components.molecules._m-intro-block')
                {!! $printedCatalogs['intro'] !!}
            @endcomponent

            @component('components.atoms._hr')
            @endcomponent

            @component('components.organisms._o-grid-listing')
                @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
                @slot('cols_large','4')
                @slot('cols_xlarge','4')
                @foreach ($printedCatalogs['items'] as $item)
                    @component('components.molecules._m-listing----generic')
                        @slot('variation', 'm-listing--row@small m-listing--row@medium')
                        @slot('item', $item)
                        @slot('image', $item->imageFront('listing') ?? null)
                        @slot('imgVariation', 'm-listing__img--padded')
                        @slot('imageSettings', array(
                            'crop' => 'default',
                            'fit' => 'default',
                            'srcset' => array(160,240,320),
                            'sizes' => '160px',
                        ))
                    @endcomponent
                @endforeach
            @endcomponent

            @component('components.molecules._m-links-bar')
                @slot('variation', 'm-links-bar--title-bar-companion')
                @slot('linksPrimary', array(
                    array(
                        'label' => 'Browse all printed catalogs',
                        'href' => route('collection.publications.printed-catalogs'),
                        'variation' => 'btn btn--secondary'
                    ),
                ))
            @endcomponent
        </section>

        <section>
            @component('components.molecules._m-title-bar')
                @slot('links', array(array('label' => 'Browse all journal entries', 'href' => route('collection.publications.scholarly-journals'))))
                Scholarly Journals
            @endcomponent

            @component('components.atoms._hr')
            @endcomponent

            <div class="o-feature-plus-4">
                @if ($journalHero)
                  @component('components.molecules._m-listing----article')
                      @slot('tag', 'p')
                      @slot('titleFont', 'f-headline-editorial')
                      @slot('captionFont', 'f-body-editorial')
                      @slot('variation', 'o-feature-plus-4__feature')
                      @slot('item', $journalHero)
                      @slot('imageSettings', array(
                          'fit' => 'crop',
                          'ratio' => '16:9',
                          'srcset' => array(200,400,600,1000),
                          'sizes' => aic_imageSizes(array(
                                'xsmall' => '58',
                                'small' => '58',
                                'medium' => '38',
                                'large' => '28',
                                'xlarge' => '28',
                          )),
                      ))
                  @endcomponent
                @endif

                <ul class="o-feature-plus-4__items-1">
                @foreach ($journals as $editorial)
                    @if ($loop->index < 2)
                        @component('components.molecules._m-listing----article-minimal')
                            @slot('item', $editorial)
                            @slot('imageSettings', array(
                                'fit' => 'crop',
                                'ratio' => '16:9',
                                'srcset' => array(200,400,600),
                                'sizes' => aic_imageSizes(array(
                                      'xsmall' => '58',
                                      'small' => '28',
                                      'medium' => '18',
                                      'large' => '13',
                                      'xlarge' => '13',
                                )),
                            ))
                        @endcomponent
                    @endif
                @endforeach
                </ul>
                <ul class="o-feature-plus-4__items-2">
                @foreach ($journals as $editorial)
                    @if ($loop->index > 1)
                        @component('components.molecules._m-listing----article-minimal')
                            @slot('item', $editorial)
                            @slot('imageSettings', array(
                                'fit' => 'crop',
                                'ratio' => '16:9',
                                'srcset' => array(200,400,600),
                                'sizes' => aic_imageSizes(array(
                                      'xsmall' => '58',
                                      'small' => '28',
                                      'medium' => '18',
                                      'large' => '13',
                                      'xlarge' => '13',
                                )),
                            ))
                        @endcomponent
                    @endif
                @endforeach
                </ul>
            </div>

            @component('components.molecules._m-links-bar')
                @slot('variation', 'm-links-bar--title-bar-companion')
                @slot('linksPrimary', array(
                    array(
                        'label' => 'Browse all journal entries',
                        'href' => route('collection.publications.scholarly-journals'),
                        'variation' => 'btn btn--secondary'
                    ),
                ))
            @endcomponent
        </section>
    </article>


@endsection
