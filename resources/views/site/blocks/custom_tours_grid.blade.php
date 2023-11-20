<h2 id="{{ StringHelpers::getUtf8Slug($block->input('custom_tours_grid_heading')) }}" class="title f-headline">{!! $block->input('custom_tours_grid_heading') !!}</h2>
{{--Todo: Set up field and remove hard coded text --}}
<p>Browse a list of existing self-guided tours you can take at the museum, or select one that you can recommend and share with others.</p>
<div class="featured-pages-grid" data-blur-img>
    <div class="featured-pages-grid_row">
        @foreach($block->getRelated('custom_tours_items') as $index => $custom_tour)
            <div class="featured-pages-grid_card">
                <div class="featured-pages-grid_details">

                        @if($custom_tour->imageAsArray('teaser_image'))
                            @component('components.atoms._img')
                                @slot('class', 'featured-pages-grid_img')
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
                            <span class="default-img featured-pages-grid_img"></span>
                        @endif
                        <span>
                            <h3 class="f-list-2">{!! $custom_tour->title !!}
                                <svg class='icon--arrow'><use xlink:href='#icon--arrow'></use></svg>
                            </h3>
                        </span>
                        <a href="{{ route('custom-tours.show', $custom_tour->tour_id) }}" class="btn btn--secondary f-buttons">
                            View tour
                        </a>
                </div>
            </div>
        @endforeach
    </div>
</div>

