@if ($block->input('custom_tours_grid_heading'))
    <h2 id="{{ StringHelpers::getUtf8Slug($block->input('custom_tours_grid_heading')) }}" class="title f-headline">
        {!! strip_tags($block->input('custom_tours_grid_heading'), '<em>') !!}
    </h2>
@endif

@if ($block->input('custom_tours_grid_text'))
    <div class="aic-ct-grid-intro f-body">
        {!! $block->input('custom_tours_grid_text') !!}
    </div>
@endif

<div class="aic-ct-grid-container" data-blur-img>
    @foreach($block->getRelated('custom_tours_items') as $index => $custom_tour)
        <div class="aic-ct-grid-card">
            <div class="aic-ct-grid-card__top">
                @if($custom_tour->imageAsArray('teaser_image'))
                    @component('components.atoms._img')
                        @slot('class', 'aic-ct-grid-card__img')
                        @slot('image', $custom_tour->imageAsArray('teaser_image'))
                        @slot('settings', array(
                            'fit' => 'crop',
                            'ratio' => '67:40',
                            'srcset' => array(300,600,800,1200,1600),
                            'sizes' => ImageHelpers::aic_imageSizes(array(
                              'xsmall' => 58,
                              'small' => 58,
                              'medium' => 58,
                              'large' => 38,
                              'xlarge' => 38,
                            ))))
                    @endcomponent
                @else
                    <span class="default-img aic-ct-grid-card__img"></span>
                @endif

                <div class="aic-ct-grid-card__overlay">
                    <h3 class="aic-ct-grid-card__title f-headline-editorial">{!! $custom_tour->title !!}</h3>
                </div>
            </div>

            <div class="aic-ct-grid-card__details">
                @if ($custom_tour->artwork_count)
                    <div class="aic-ct-artworks-count-container">
                        <svg aria-hidden="true" class="icon--close"><use xlink:href="#icon--image-stack" /></svg>
                        <div class="f-module-title-1">
                            {!! $custom_tour->artwork_count !!}
                        </div>
                    </div>
                @endif
                @if ($custom_tour->teaser_text)
                    <div class="aic-ct-grid-card__text f-deck">
                        {!! $custom_tour->teaser_text !!}
                    </div>
                @endif
                @if ($custom_tour->tour_id)
                    <a href="{{ route('custom-tours.show', $custom_tour->tour_id) }}" class="btn btn--secondary f-buttons">
                        View tour
                    </a>
                @endif
            </div>
        </div>
    @endforeach
</div>

