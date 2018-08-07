<div class="o-accordion{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="accordion">
    @foreach ($items as $item)
    <h3 id="{{ getUtf8Slug($item['title']) }}" class="o-accordion__trigger {{ $titleFont ?? 'f-list-3' }}" tabindex="0"{!! (isset($item['gtmAttributes'])) ? ' '.$item['gtmAttributes'].'' : '' !!}>
        {{ $item['title'] }}
        <span class="o-accordion__trigger-icon">
            <svg class="icon--plus"><use xlink:href="#icon--plus" /></svg>
            <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
        </span>
    </h3>
    <div id="panel_{{ getUtf8Slug($item['title']) }}" class="o-accordion__panel" aria-labelledby="{{ getUtf8Slug($item['title']) }}" aria-hidden="{{ (isset($item['active']) and $item['active']) ? 'false' : 'true' }}">
        <div class="o-accordion__panel-content o-blocks">
            @component('components.blocks._blocks')
                @slot('blocks', $item['blocks'])
            @endcomponent
        </div>
    </div>
    @endforeach
</div>
