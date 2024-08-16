<div class="o-accordion{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="accordion">
    @foreach ($items as $item)
        @php
            $isArticleInTree = function ($items) use (&$isArticleInTree, $currentArticle) {
                foreach ($items as $childItem) {
                    if ($childItem->id === $currentArticle->id) {
                        return true;
                    }
                    if (count($childItem->children) > 0 && $isArticleInTree($childItem->children)) {
                        return true;
                    }
                }
                return false;
            };

            $isInTree = $isArticleInTree($item->children);
            $isExpanded = isset($currentArticle) && ($currentArticle->parent === $item || $isInTree);
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
                <a class="m-link-list__trigger f-secondary {{ $item->url === request()->url() ? 'active' : '' }}" href="{{ $item->url }}"{!! (isset($item->gtmAttributes)) ? ' '.$item->gtmAttributes.'' : '' !!}>
                    <span class="m-link-list__label">{!! $item->title !!}</span>
                </a>
            </span>
        @endif
    @endforeach
</div>
