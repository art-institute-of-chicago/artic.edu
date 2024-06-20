<div class="o-accordion{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="accordion">
    @foreach ($items as $item)
        <h3>
            <button id="{{ StringHelpers::getUtf8Slug($item['title']) }}" class="o-accordion__trigger {{ $titleFont ?? 'f-list-3' }}" tabindex="0"{!! (isset($item['gtmAttributes'])) ? ' '.$item['gtmAttributes'].'' : '' !!} aria-expanded="{{ (isset($item['active']) and $item['active']) ? 'true' : 'false' }}">
                {!! $item['title'] !!}
                @if (count($item['items']) > 0)
                    <span class="o-accordion__trigger-icon">
                        <svg class="icon--plus"><use xlink:href="#icon--plus" /></svg>
                        <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
                    </span>
                @endif
            </button>
        </h3>
        @if (count($item['items']) > 0)
            <div id="panel_{{ StringHelpers::getUtf8Slug($item['title']) }}" class="o-accordion__panel" aria-labelledby="{{ StringHelpers::getUtf8Slug($item['title']) }}" aria-hidden="{{ (isset($item['active']) and $item['active']) ? 'false' : 'true' }}">
                {{-- In the same tune of the build nested articles we can just recursively call the same component to build the table of contents. --}}
                @include('components.organisms._o-table-of-contents', ['items' => $item['items']])
            </div>
        @endif
    @endforeach
</div>