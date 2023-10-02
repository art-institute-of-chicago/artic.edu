@foreach($block->getRelated('customToursItems') as $index => $custom_tour)
    @php
        $image = $custom_tour->imageAsArray('teaser_image');
    @endphp
    <div class="featured-pages-grid_card">
        <div class="featured-pages-grid_details">
            <span>
                <h3 class="f-list-2">
                    {{ $custom_tour->title }}
                    <svg class='icon--arrow'><use xlink:href='#icon--arrow'></use></svg>
                    {{ $custom_tour->tour_id }}
                </h3>

                @if ($custom_tour->teaser_text)
                    <p>{{ $custom_tour->teaser_text }}</p>
                @endif
                
                <a href="/custom-tours/{{ $custom_tour->tour_id }}" class="m-listing__link">
                    @if ($image)
                        @component('components.atoms._img')
                            @slot('class', 'featured-pages-grid_img')
                            @slot('image', $image)
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
                </a>

            </span>
        </div>
    </div>
@endforeach

