<h2 id="{{ StringHelpers::getUtf8Slug($block->input('grid_heading')) }}" class="title f-module-title-2">{{ $block->input('grid_heading') }}</h2>
<hr/>
<div class="featured-pages-grid" data-blur-img>
    @foreach($block->getRelated('genericPages') as $index => $page)
        @if($index === count($block->getRelated('genericPages')) || $index !== 0 && $index % 4 === 0)
            </div>
        @endif
        @if($loop->first || $index % 4 === 0)
            <div class="featured-pages-grid_row">
        @endif
        <div class="featured-pages-grid_card">
            <div class="featured-pages-grid_details">
                <a href="{{ $page->getURL() }}" class="m-listing__link">
                    @if($page->imageFront('listing') ?? $page->imageFront('hero'))
                        @component('components.atoms._img')
                            @slot('class', 'featured-pages-grid_img')
                            @slot('image', $page->imageFront('listing') ?? $page->imageFront('hero'))
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
                        <h3 class="f-list-2">{{ $page->title }}
                            <svg class='icon--arrow'><use xlink:href='#icon--arrow'></use></svg>
                        </h3>
                    </span>
                </a>
            </div>
        </div>
    @endforeach
</div>
