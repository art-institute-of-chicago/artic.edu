<article>
    <header>
        @component('components.molecules._m-header-block')
            @slot('tag', 'div')
            {!! SmartyPants::defaultTransform($title) !!}
        @endcomponent

        @component('components.molecules._m-intro-block')
            @slot('variation', 'm-intro-block--tight')
            {!! SmartyPants::defaultTransform($intro) !!}
        @endcomponent
    </header>

    @component('components.molecules._m-links-bar')
        @slot('variation', 'm-links-bar--tabs')
        @slot('overflow', true)
        @slot('isPrimaryPageNav', true)
        @slot('linksPrimary', $linksBar)
    @endcomponent

    @if ($item->imageFront('research_landing_image'))
        <article class="m-post-hero">
            <figure class="m-post-hero__image">
                @component('components.atoms._img')
                    @slot('image', $item->imageFront('research_landing_image'))
                    @slot('settings', [
                        'srcset' => array(300,600,800,1200,1600,3000,4500),
                        'sizes' => ImageHelpers::aic_imageSizes(array(
                              'xsmall' => 58,
                              'small' => 58,
                              'medium' => 58,
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
                    {!! $item->present()->resources_landing_title !!}
                @endcomponent

                @if (!empty($item->resources_landing_intro))
                    @component('components.blocks._text')
                        @slot('font','f-body')
                        {!! $item->present()->resources_landing_intro !!}
                    @endcomponent
                @endif
            </div>
        </article>
    @endif

    @component('components.atoms._hr')
    @endcomponent
