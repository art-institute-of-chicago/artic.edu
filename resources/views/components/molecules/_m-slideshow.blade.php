<div class="i-{{ $_implementation }} m-slideshow {{ $variation ?? '' }}">
    @if($_implementation == '1')

        <div class="m-slideshow__carousel">
            @foreach ($slides as $slide)
                <div id="i-{{ $_implementation }}-slide-{{ $loop->iteration }}" class="m-slideshow__slide">
                    @component('components.atoms._img')
                        @slot('class', 'm-showcase-image')
                        @slot('image', $slide)
                        @slot('settings', $imageSettings)
                    @endcomponent
                </div>
            @endforeach
        </div>
        <div class="m-slideshow__navigation">
            @foreach ($slides as $slide)
                <a href="#i-{{ $_implementation }}-slide-{{ $loop->iteration }}" clas="m-slideshow__position">
                    {{ $loop->iteration }}
                </a>
            @endforeach
        </div>

    @elseif($_implementation == '2')

        <ol class="m-slideshow__carousel">
            @foreach ($slides as $slide)
                <li id="i-{{ $_implementation }}-slide-{{ $loop->iteration }}" tabindex="0" class="m-slideshow__slide">
                    @component('components.atoms._img')
                        @slot('class', 'm-showcase-image')
                        @slot('image', $slide)
                        @slot('settings', $imageSettings)
                    @endcomponent
                    {{-- <div class="carousel__snapper">
                        <a href="#carousel__slide4" class="carousel__prev">Go to last slide</a>
                        <a href="#carousel__slide2" class="carousel__next">Go to next slide</a>
                    </div> --}}
                </li>
            @endforeach
        </ol>
        <aside class="m-slideshow__navigation">
            <ol class="m-slideshow__navigation-list">
                @foreach ($slides as $slide)
                    <li class="m-slideshow__navigation-item">
                        <a href="#i-{{ $_implementation }}-slide-{{ $loop->iteration }}" class="m-slideshow__position">
                            {{ $loop->iteration }}
                        </a>
                    </li>
                @endforeach
            </ol>
        </aside>

    @endif
</div>
