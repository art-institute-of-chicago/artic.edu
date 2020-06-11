<section>
    @component('components.molecules._m-title-bar')
        @slot('links',
            array(array('label' => 'Browse all articles', 'href' => route('articles'), 'gtmAttributes' => 'data-gtm-event="browse-all-articles" data-gtm-event-action="' . $seo->title . '"  data-gtm-event-category="nav-link"'))
        )
        @slot('variation', 'm-title-bar--no-hr')
        Blog
    @endcomponent

    @component('components.atoms._hr')
    @endcomponent

    <div class="o-feature-plus-4">
        @if ($featureHero)
            @component('components.molecules._m-listing----' . strtolower($featureHero->type))
                @slot('tag', 'div')
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
                @slot('gtmAttributes', 'data-gtm-event="article-'. $featureHero->id . '-' . $featureHero->trackingTitle . '" data-gtm-event-action="' . $seo->title . '" data-gtm-event-category="blog-listing-1"')
            @endcomponent
        @endif

        <h3 class="sr-only" id="h-featured-plus-1">Featured articles</h3>
        <ul class="o-feature-plus-4__items-1" aria-labelledby="h-featured-plus-1">
        @foreach ($features as $editorial)
            @if ($loop->index < 2)
                @component('components.molecules._m-listing----' . strtolower($editorial->type) . '-minimal')
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
                @slot('gtmAttributes', 'data-gtm-event="article-'. $editorial->id . '-' . $editorial->trackingTitle . '" data-gtm-event-action="' . $seo->title . '" data-gtm-event-category="blog-listing-' . ($loop->index + 2) . '"')
                @endcomponent
            @endif
        @endforeach
        </ul>
        <h3 class="sr-only" id="h-featured-plus-2">More featured articles</h3>
        <ul class="o-feature-plus-4__items-2" aria-labelledby="h-featured-plus-2">
        @foreach ($features as $editorial)
            @if ($loop->index > 1)
                @component('components.molecules._m-listing----' . strtolower($editorial->type) . '-minimal')
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
                    @slot('gtmAttributes', 'data-gtm-event="'. ($editorial->title_display ?? $editorial->title) . '" data-gtm-event-action="' . $seo->title . '" data-gtm-event-category="blog-listing-' . ($loop->index + 2) . '"')
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
                'variation' => 'btn btn--secondary',
                'gtmAttributes' => 'data-gtm-event="browse-all-articles" data-gtm-event-action="' . $seo->title . '"  data-gtm-event-category="nav-link"'
            ),
        ))
    @endcomponent
</section>
