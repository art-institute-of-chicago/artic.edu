@if($headerMedia['style'] != 'feature')
    @component('components.molecules._m-media')
        @slot('item', $headerMedia)
        @slot('tag', 'span')
        @slot('imageSettings', array(
            'srcset' => array(300,600,1000,1500,3000),
            'sizes' => '100vw',
        ))
        @slot('variation', 'm-visit-header')
    @endcomponent
@else
    @if ($mainFeatures->count() > 0)
        <div class="o-features">
            @component('components.organisms._o-feature')
                @slot('tag', 'div')
                @slot('item', $mainFeatures->first())
                @slot('isHero', true)
                @slot('gtmCount', 1)
            @endcomponent
        </div>
    @endif
    @if ($mainFeatures->count() > 1)
        <div class="o-features">
            @foreach ($mainFeatures->slice(1) as $key => $item)
                @component('components.organisms._o-feature')
                    @slot('tag', 'div')
                    @slot('item', $item)
                    @slot('isHero', false)
                    @slot('gtmCount', $key + 1)
                @endcomponent
            @endforeach
        </div>
    @endif
@endif