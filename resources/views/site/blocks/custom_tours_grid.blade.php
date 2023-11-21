@if ($block->input('custom_tours_grid_heading'))
    <h2 id="{{ StringHelpers::getUtf8Slug($block->input('custom_tours_grid_heading')) }}" class="title f-headline">
        {!! strip_tags($block->input('custom_tours_grid_heading'), '<em>') !!}
    </h2>
@endif

@if ($block->input('custom_tours_grid_text'))
    <div class="aic-ct-grid-intro">
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
                    <span class="default-img aic-ct-grid-card__img"></span>
                @endif

                <div class="aic-ct-grid-card__overlay">
                    <h3 class="aic-ct-grid-card__title">{!! $custom_tour->title !!}</h3>
                </div>
            </div>

            <div class="aic-ct-grid-card__details">
                @if ($custom_tour->artwork_count)
                    <div class="aic-ct-grid-card__artworks-count">
                        <svg role="presentation" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M1.5 1.5C1.5 1.08579 1.83579 0.75 2.25 0.75H15.75C16.1642 0.75 16.5 1.08579 16.5 1.5V16.5C16.5 16.9142 16.1642 17.25 15.75 17.25H2.25C1.83579 17.25 1.5 16.9142 1.5 16.5V1.5Z" stroke="#7E746D" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M19.5 3.75V19.5C19.5 19.9142 19.1642 20.25 18.75 20.25H4.5" stroke="#7E746D" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M22.5 6.75V22.5C22.5 22.9142 22.1642 23.25 21.75 23.25H7.5" stroke="#7E746D" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16.5 12.75H1.5" stroke="#7E746D" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6 12.75L10.153 6.818C10.4173 6.44061 10.8403 6.20559 11.3004 6.18061C11.7604 6.15563 12.2064 6.34345 12.51 6.69L16.5 11.25" stroke="#7E746D" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M5.25 4.125C5.45711 4.125 5.625 4.29289 5.625 4.5C5.625 4.70711 5.45711 4.875 5.25 4.875C5.04289 4.875 4.875 4.70711 4.875 4.5C4.875 4.29289 5.04289 4.125 5.25 4.125" stroke="#7E746D" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div>
                            {!! $custom_tour->artwork_count !!}
                        </div>
                    </div>
                @endif
                @if ($custom_tour->teaser_text)
                    <div class="aic-ct-grid-card__text">
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

