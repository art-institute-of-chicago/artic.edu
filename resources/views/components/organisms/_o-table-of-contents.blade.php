<div class="o-accordion{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="accordion">
    @foreach ($items as $item)
        @if (count($item->children) > 0)
            <h3>
                <button id="toc-{{ StringHelpers::getUtf8Slug($item->title) }}" class="o-accordion__trigger {{ $titleFont ?? 'f-list-3' }}" tabindex="0"{!! (isset($item->gtmAttributes)) ? ' '.$item->gtmAttributes.'' : '' !!} aria-expanded="{{ (isset($item->active) and $item->active) ? 'true' : 'false' }}">
                    {!! $item->title !!}
                    <span class="o-accordion__trigger-icon">
                        <svg class="icon--plus"><use xlink:href="#icon--plus" /></svg>
                        <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
                    </span>
                </button>
            </h3>
        @else
            <span class="m-link-list__item o-accordion__panel-content">
                <a class="m-link-list__trigger f-secondary" href="{{ $item->url }}"{!! (isset($item->gtmAttributes)) ? ' '.$item->gtmAttributes.'' : '' !!}>
                    <span class="m-link-list__label">{!! $item->title !!}</span>
                </a>
            </span>
        @endif
        @if (count($item->children) > 0)
            <div id="panel_{{ StringHelpers::getUtf8Slug($item->title) }}" class="o-accordion__panel" aria-labelledby="{{ StringHelpers::getUtf8Slug($item->title) }}" aria-hidden="{{ (isset($item->active) and $item->active) ? 'false' : 'true' }}">
                {{-- In the same tune of the build nested articles we can just recursively call the same component to build the table of contents. --}}
                @include('components.organisms._o-table-of-contents', ['items' => $item->children])
            </div>
        @endif
    @endforeach
</div>
