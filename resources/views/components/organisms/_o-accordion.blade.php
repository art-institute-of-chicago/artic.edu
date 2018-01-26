<div class="o-accordion{{ (isset($variation)) ? ' '.$variation : '' }}" role="tablist" multiselectable="true" data-behavior="accordion">
    @foreach ($items as $item)
    <h3 id="tab_{{ $loopIndex }}_{{ $loop->iteration }}" class="o-accordion__trigger {{ $titleFont ?? 'f-module-title-2' }}" aria-selected="{{ (isset($item['active']) and $item['active']) ? 'true' : 'false' }}" aria-controls="panel_{{ $loopIndex }}_{{ $loop->iteration }}" aria-expanded="{{ (isset($item['active']) and $item['active']) ? 'true' : 'false' }}" role="tab" tabindex="0">
        {{ $item['title'] }}
        <svg class="icon--plus"><use xlink:href="#icon--plus" /></svg>
        <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
    </h3>
    <div id="panel_{{ $loopIndex }}_{{ $loop->iteration }}" class="o-accordion__panel" aria-labelledby="tab_{{ $loopIndex }}_{{ $loop->iteration }}" aria-hidden="{{ (isset($item['active']) and $item['active']) ? 'false' : 'true' }}" role="tabpanel">
        <div class="o-accordion__panel-content o-blocks">
            @component('components.blocks._blocks')
                @slot('blocks', $item['blocks'])
            @endcomponent
        </div>
    </div>
    @endforeach
</div>
