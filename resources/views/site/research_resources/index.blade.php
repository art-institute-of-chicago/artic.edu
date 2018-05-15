@extends('layouts.app')

@section('content')

    <article>
        <header>
            @component('components.molecules._m-header-block')
                @slot('tag', 'div')
                {{ $page->resources_landing_title }}
            @endcomponent

            @component('components.molecules._m-intro-block')
                @slot('variation', 'm-intro-block--tight')
                {!! $page->resources_landing_intro !!}
            @endcomponent
        </header>

        @component('components.molecules._m-links-bar')
            @slot('variation', 'm-links-bar--tabs')
            @slot('overflow', true)
            @slot('linksPrimary', $linksBar)
        @endcomponent

        @if ($page->imageFront('research_landing_image'))
            <article class="m-post-hero">
                <div class="m-post-hero__inner">
                    <figure class="m-post-hero__image">
                        @component('components.atoms._img')
                            @slot('image', $page->imageFront('research_landing_image'))
                            @slot('settings', [
                                'srcset' => array(300,600,800,1000,1500),
                                'sizes' => aic_imageSizes(array(
                                      'xsmall' => 58,
                                      'small' => 38,
                                      'medium' => 38,
                                      'large' => 38,
                                      'xlarge' => 38,
                                ))
                            ])
                        @endcomponent
                    </figure>

                    <div class="m-post-hero__main">
                        @component('components.blocks._text')
                            @slot('font','f-list-4')
                            @slot('tag','h3')
                            {{ $page->resources_landing_title }}
                        @endcomponent

                        @if (!empty($page->resources_landing_intro))
                            @component('components.blocks._text')
                                @slot('font','f-body')
                                {{ $page->resources_landing_intro }}
                            @endcomponent
                        @endif
                    </div>
                </div>
            </article>
        @endif

        @component('components.atoms._hr')
        @endcomponent

        @component('components.organisms._o-grid-listing')
            @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows')
            @slot('cols_large','3')
            @slot('cols_xlarge','3')
            @foreach ($items as $item)
                @component('components.molecules._m-listing----multi-links')
                    @slot('variation', 'm-listing--row@small m-listing--row@medium')
                    @slot('item', $item)
                    @slot('imageSettings', array(
                        'fit' => 'crop',
                        'ratio' => '16:9',
                        'srcset' => array(200,400,600,800),
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

        <section>
            @component('components.molecules._m-title-bar')
                @slot('links', array(array('label' => 'More about Study rooms', 'href' => $studyRoomsLink)))
                Study Rooms
            @endcomponent

            @component('components.atoms._hr')
            @endcomponent

            @component('components.organisms._o-grid-listing')
                @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
                @slot('cols_large','3')
                @slot('cols_xlarge','3')

                @foreach ($studyRooms as $item)
                    @component('components.molecules._m-listing----multi-links')
                        @slot('variation', 'm-listing--row@small m-listing--row@medium')
                        @slot('item', $item)
                    @endcomponent
                @endforeach
            @endcomponent

            @component('components.molecules._m-links-bar')
                @slot('variation', 'm-links-bar--title-bar-companion')
                @slot('linksPrimary', array(
                    array(
                        'label' => 'More about Study rooms',
                        'href' => $studyRoomsLink,
                        'variation' => 'btn btn--secondary'
                    ),
                ))
            @endcomponent
        </section>
    </article>

@endsection
