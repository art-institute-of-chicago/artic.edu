<div class="o-accordion{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="accordion">
    @foreach ($items as $item)
    <h3><button id="{{ StringHelpers::getUtf8Slug($item['title']) }}" class="o-accordion__trigger {{ $titleFont ?? 'f-list-3' }}" tabindex="0"{!! (isset($item['gtmAttributes'])) ? ' '.$item['gtmAttributes'].'' : '' !!} aria-expanded="{{ (isset($item['active']) and $item['active']) ? 'true' : 'false' }}">
        {!! $item['title'] !!}
        <span class="o-accordion__trigger-icon">
            <svg class="icon--plus"><use xlink:href="#icon--plus" /></svg>
            <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
        </span>
    </button></h3>
    <div id="panel_{{ StringHelpers::getUtf8Slug($item['title']) }}" class="o-accordion__panel" aria-labelledby="{{ StringHelpers::getUtf8Slug($item['title']) }}" aria-hidden="{{ (isset($item['active']) and $item['active']) ? 'false' : 'true' }}">
        <div class="o-accordion__panel-content o-blocks">
            @component('components.blocks._blocks')
                @slot('blocks', $item['blocks'])
            @endcomponent
        </div>
    </div>
    @endforeach
</div>
