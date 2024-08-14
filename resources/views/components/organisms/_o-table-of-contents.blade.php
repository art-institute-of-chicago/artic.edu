<div class="o-accordion{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="accordion">
    @foreach ($items as $item)
        @if (count($item->children) > 0)
            <h3>
                <button id="toc-{{ StringHelpers::getUtf8Slug($item->title) }}" class="o-accordion__trigger {{ $titleFont ?? 'f-list-3' }}" tabindex="0"{!! (isset($item->gtmAttributes)) ? ' '.$item->gtmAttributes.'' : '' !!} aria-expanded="true">
                    {!! $item->title !!}
                    <span class="o-accordion__trigger-icon">
                        <svg class="icon--plus
                        "><use xlink:href="#icon--plus" /></svg>
                        <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
                    </span>
                </button>
            </h3>
            @foreach ($item->children as $child)
                <div id="panel_{{ StringHelpers::getUtf8Slug($item->title) }}" class="o-accordion__panel" aria-labelledby="{{ StringHelpers::getUtf8Slug($item->title) }}" aria-hidden="false">
                    @include('components.organisms._o-table-of-contents', ['items' => $item->children->sortBy('position')])
                </div>
            @endforeach
        @else
            <span class="m-link-list__item o-accordion__panel-content">
                <a class="m-link-list__trigger f-secondary" href="{{ $item->url }}"{!! (isset($item->gtmAttributes)) ? ' '.$item->gtmAttributes.'' : '' !!}>
                    <span class="m-link-list__label">{!! $item->title !!}</span>
                </a>
            </span>
        @endif
    @endforeach
</div>
