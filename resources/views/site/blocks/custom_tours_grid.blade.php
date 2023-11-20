<h2 id="{{ StringHelpers::getUtf8Slug($block->input('custom_tours_grid_heading')) }}" class="title f-headline">{!! $block->input('custom_tours_grid_heading') !!}</h2>
{{--Todo: Set up field and remove hard coded text --}}
<p>Browse a list of existing self-guided tours you can take at the museum, or select one that you can recommend and share with others.</p>
<div class="aic-ct-grid" data-blur-img>
    @foreach($block->getRelated('custom_tours_items') as $index => $custom_tour)
        <div class="aic-ct-grid-card">
            @if($custom_tour->imageAsArray('teaser_image'))
                @component('components.atoms._img')
                    @slot('class', 'aic-ct-grid-card__img')
                    @slot('image', $custom_tour->imageAsArray('teaser_image'))
                    @slot('settings', array(
                        'fit' => 'crop',
                        'ratio' => '16:9',
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
                {{-- Todo: Is "default-img" needed here? e.g. padding: 0; --}}
                <span class="default-img aic-ct-grid-card__img"></span>
            @endif

            <h3 class="f-list-2">{!! $custom_tour->title !!}
                <svg class='icon--arrow'><use xlink:href='#icon--arrow'></use></svg>
            </h3>
            <div class="aic-ct-grid-card__details">
                <div class="aic-ct-grid-card__text">
                    {!! $custom_tour->teaser_text !!}
                </div>
                <a href="{{ route('custom-tours.show', $custom_tour->tour_id) }}" class="btn btn--secondary f-buttons">
                    View tour
                </a>
            </div>
        </div>
    @endforeach
</div>

