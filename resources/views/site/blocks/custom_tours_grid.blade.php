@foreach($block->getRelated('customToursItems') as $index => $page)
    <div class="featured-pages-grid_card">
        <div class="featured-pages-grid_details">
            <span>
                <h3 class="f-list-2">
                    {{ $page->title }}
                    <svg class='icon--arrow'><use xlink:href='#icon--arrow'></use></svg>
                    {{ $page->tour_id }}
                </h3>
                <p>{{ $page->teaser_text }}</p>
                @php
                    $image = $page->imageAsArray('teaser_image')
                @endphp

                <img src="{{ $image['src'] }}" alt="{{ $image['alt']  }}"/>

{{--                @component('components.atoms._img')--}}
{{--                    @slot('img', $page->imageAsArray('teaser_image'))--}}
{{--                @endcomponent--}}
            </span>
        </div>
    </div>
@endforeach

