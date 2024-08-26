<div class="o-accordion{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="accordion">
    @foreach ($items as $item)
        @php
            if (isset($currentArticle)) {
                $isExpanded = $currentArticle->parent === $item || $currentArticle->present()->isArticleInTree($item->children);
            } else {
                $isExpanded = true;
            }
            $isActive = isset($currentArticle) && $item->id === $currentArticle->id;

            if ($item->type === App\Enums\DigitalPublicationArticleType::Grouping) {
                $href = route(
                    'collection.publications.digital-publications.showListing',
                    [
                        'id' => $item->digitalPublication->id,
                        'slug' => $item->digitalPublication->getSlug()
                    ]
                ) . '#' . Str::kebab($item->title);
            } else {
                $href = $item->url;
            }
        @endphp

        @if (count($item->children) > 0)
            <h3>
                <button id="toc-{{ StringHelpers::getUtf8Slug($item->title) }}" class="o-accordion__trigger {{ $titleFont ?? 'f-list-3' }}" tabindex="0"{!! (isset($item->gtmAttributes)) ? ' '.$item->gtmAttributes.'' : '' !!} aria-expanded="{{ $isExpanded ? 'true' : 'false' }}">
                    {!! $item->title !!}
                    <span class="o-accordion__trigger-icon">
                        <svg class="icon--plus"><use xlink:href="#icon--plus" /></svg>
                        <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
                    </span>
                </button>
            </h3>
            <div id="panel_{{ StringHelpers::getUtf8Slug($item->title) }}" class="o-accordion__panel" aria-labelledby="{{ StringHelpers::getUtf8Slug($item->title) }}" aria-hidden="{{ $isExpanded ? 'false' : 'true' }}">
                @include('components.organisms._o-table-of-contents', ['items' => $item->children->sortBy('position')])
            </div>
        @else
            <span class="m-link-list__item o-accordion__panel-content">
                <a class="m-link-list__trigger f-secondary {{ $isActive ? 'active' : '' }}" href="{{ $href }}"{!! (isset($item->gtmAttributes)) ? ' '.$item->gtmAttributes.'' : '' !!}>
                    <span class="m-link-list__label">{!! $item->title !!}</span>
                </a>
            </span>
        @endif
    @endforeach
</div>
