<div class="featured-pages-grid" data-blur-img>
    @foreach($block->getRelated('customToursLandingPageItems') as $index => $page)
        @if($index === count($block->getRelated('customToursLandingPageItems')) || $index !== 0 && $index % 4 === 0)
            </div>
        @endif
        @if($loop->first || $index % 4 === 0)
             <div class="featured-pages-grid_row">
        @endif
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
</div>
