<div class="m-slideshow {{ $variation ?? '' }}" data-behavior="slideshow">
    <div class="slideshow-display">
        <div class="slideshow-carousel">
            @foreach ($slides as $index => $slide)
                <div class="slideshow-slide">
                    @component('components.atoms._img')
                        @slot('id', "slideshow-slide-$index")
                        @slot('class', 'm-showcase-image')
                        @slot('image', $slide)
                        @if ($imagesSettings ?? false)
                            @slot('settings', $imagesSettings)
                        @endif
                    @endcomponent
                </div>
            @endforeach
        </div>
    </div>

    <div class="slideshow-position">
        @foreach ($slides as $index => $slide)
            <button
                id="slideshow-position-{{ $index }}"
                class="slideshow-position-pip @if($index == 0) slideshow-position-current @endif"
            ></button>
        @endforeach
    </div>
</div>
