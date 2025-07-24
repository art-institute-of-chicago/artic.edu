<div class="m-slideshow {{ $variation ?? '' }}" data-behavior="slideshow">
    <div class="slideshow-display">
        <div class="slideshow-carousel">
            @foreach ($slides as $index => $slide)
                @component('components.atoms._img')
                    @slot('id', "slideshow-slide-$index")
                    @slot('class', 'm-showcase-image slideshow-slide')
                    @slot('image', $slide)
                    @if ($imagesSettings ?? false)
                        @slot('settings', $imagesSettings)
                    @endif
                @endcomponent
            @endforeach
        </div>
    </div>

    <div class="slideshow-position">
        @foreach ($slides as $index => $slide)
            <button
                id="slideshow-position-{{ $index }}"
                class="slideshow-position-pip @if($index == 0) slideshow-current-position @endif"
            ></button>
        @endforeach
    </div>
</div>
