@foreach($block->getRelated('customToursLandingPageItems') as $index => $page)
    <div class="featured-pages-grid_card">
        <div class="featured-pages-grid_details">
            <span>
                <h3 class="f-list-2">
                    {{ $page->title }}
                    <svg class='icon--arrow'><use xlink:href='#icon--arrow'></use></svg>
                    {{ $page->tour_id }}
                </h3>
            </span>
        </div>
    </div>
@endforeach

