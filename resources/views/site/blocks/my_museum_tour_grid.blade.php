@if ($block->input('my_museum_tour_grid_heading'))
    <h2 id="{{ StringHelpers::getUtf8Slug($block->input('my_museum_tour_grid_heading')) }}" class="title f-headline">
        {!! strip_tags($block->input('my_museum_tour_grid_heading'), '<em>') !!}
    </h2>
@endif

@if ($block->input('my_museum_tour_grid_text'))
    <div class="aic-ct-grid-intro f-body">
        {!! $block->input('my_museum_tour_grid_text') !!}
    </div>
@endif

<div class="aic-ct-grid-container" data-blur-img>
    @foreach($block->getRelated('myMuseumTourItems') as $index => $my_museum_tour)
        <div class="aic-ct-grid-card">
            @if ($my_museum_tour->tour_id)
                <a href="{{ route('my-museum-tour.show', $my_museum_tour->tour_id) }}">
            @endif
            <div class="aic-ct-grid-card__top">
                @if($my_museum_tour->imageAsArray('teaser_image'))
                    @component('components.atoms._img')
                        @slot('class', 'aic-ct-grid-card__img')
                        @slot('image', $my_museum_tour->imageAsArray('teaser_image'))
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
                    <h3 class="aic-ct-grid-card__title f-headline-editorial">{!! $my_museum_tour->title !!}</h3>
                </div>
            </div>
            @if ($my_museum_tour->tour_id)
                </a>
            @endif

            <div class="aic-ct-grid-card__details">
                @if ($my_museum_tour->artwork_count)
                    <div class="aic-ct-artworks-count-container">
                        <svg aria-hidden="true" class="icon--image-stack"><use xlink:href="#icon--image-stack" /></svg>
                        <div class="f-module-title-1">
                            {!! $my_museum_tour->artwork_count !!}
                        </div>
                    </div>
                @endif
                @if ($my_museum_tour->teaser_text)
                    <div class="aic-ct-grid-card__text f-deck">
                        <p>
                            {!! $my_museum_tour->teaser_text !!}
                        </p>
                    </div>
                @endif
                @if ($my_museum_tour->tour_id)
                    <a href="{{ route('my-museum-tour.show', $my_museum_tour->tour_id) }}" class="btn btn--secondary f-buttons">
                        View tour
                    </a>
                @endif
            </div>
        </div>
    @endforeach
</div>
