<{{ $tag or 'li' }} class="m-listing m-listing--w-meta-bottom{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-behavior="blurMyBackground"' : '' !!}>
  <a href="{!! $item->web_url !!}" class="m-listing__link">
    <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}"{{ (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-blur-img' : '' }}>
        @if ($item->videoFront)
            @component('components.atoms._video')
                @slot('video', $item->videoFront)
                @slot('autoplay', true)
                @slot('loop', true)
                @slot('muted', true)
            @endcomponent
        @elseif ($item->imageFront('hero'))
            @component('components.atoms._img')
                @slot('image', $item->imageFront('hero'))
                @slot('settings', $imageSettings ?? '')
            @endcomponent
        @endif
        <span class="m-listing__img-prompt f-buttons">
            {{ $item->title }}
        </span>
    </span>
    <span class="m-listing__meta"{{ (isset($variation) and strrpos($variation, "--hero") > -1) ? ' data-blur-clip-to' : '' }}>
        @component('components.atoms._type')
            Offer
        @endcomponent
        <br>
        @component('components.atoms._title')
            @slot('font', $titleFont ?? 'f-list-4')
            {{ $item->title }}
        @endcomponent
        <br>
        <span class="intro {{ $captionFont ?? 'f-body' }}">{{ $item->description }}</span>
        <br>
        <span class="m-listing__meta-bottom">
            @if ($item->priceSale)
                @component('components.atoms._price')
                    @slot('salePrice')
                        {{ $item->currency }}{{ $item->price }}
                    @endslot
                    {{ $item->currency }}{{ $item->priceSale }}
                @endcomponent
            @else
                @component('components.atoms._price')
                    {{ $item->currency }}{{ $item->price }}
                @endcomponent
            @endif

{{--             @component('components.atoms._price')
                @slot('variation','price--offer')
                {{ $item->currency }}{{ $item->price }}
            @endcomponent --}}
        </span>
    </span>
  </a>
</{{ $tag or 'li' }}>
