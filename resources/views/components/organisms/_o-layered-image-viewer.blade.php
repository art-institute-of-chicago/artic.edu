{{--
    comment out template code until we have access to uploads

    @if (isset($images) && !empty($images))
        @foreach ($images as $image)
            @component('components.molecules._m-layered-image-viewer-layer')
                @slot('item', $image)
            @endcomponent
        @endforeach
    @endif

    @if (isset($overlays) && !empty($overlays))
        @foreach ($overlays as $overlay)
            @component('components.molecules._m-layered-image-viewer-layer')
                @slot('item', $overlay)
            @endcomponent
        @endforeach
    @endif


    @if (isset($captionTitle))
        <div>
            <div class="{{ isset($captionTitle) ? 'f-caption-title' : 'f-caption' }}">
                <div>
                    {!! $captionTitle !!}
                </div>
            </div>
            <br>
        </div>
    @endif
    @if (isset($captionText))
        <div class="f-caption">{!! $captionText !!}</div>
    @endif


--}}

{{-- Hard coded viewer --}}
<div class="o-layered-image-viewer{{ (isset($variation)) ? ' '.$variation : '' }}" data-size="{{ (isset($images[0]['size'])) ? $images[0]['size'] : 'm' }}" data-behavior="layeredImageViewer">
    {{-- If images --}}
    @if (isset($images) && !empty($images))
        <div class="o-layered-image-viewer__images">
            @foreach ($images as $image)
                {{-- Repeat div for every image (figure inside is just hardcoded copy of what seems to come out of molecule) --}}
                <div class="o-layered-image-viewer__image">
                    @component('components.molecules._m-layered-image-viewer-layer')
                        @slot('item', $image)
                    @endcomponent
                </div>
            @endforeach
        </div>
    @endif

    {{-- If annotations --}}
    <div class="o-layered-image-viewer__annotations">
        {{-- Repeat div for every annotation --}}
        <div class="o-layered-image-viewer__annotation">
          <figure class="m-media m-media--m m-media--contain">
            <div class="m-media__img" data-behavior="fitText">
              <div
                class="m-media__contain--spacer"
                style="padding-bottom: 62.5%"
              ></div>
              <img
                src="https://res.cloudinary.com/ds4ie2hdu/image/upload/v1674586294/Whistler2_1912_141_NRM_anno-9_mfg79z.svg"
                alt="Alt text for the first image"
                {{-- Important to include this, must be largest size available: --}}
                data-viewer-src="https://res.cloudinary.com/ds4ie2hdu/image/upload/v1674586294/Whistler2_1912_141_NRM_anno-9_mfg79z.svg"
              />
            </div>
            <figcaption>
              <div class="f-caption">Outline of main characters</div>
            </figcaption>
          </figure>
        </div>
        <div class="o-layered-image-viewer__overlay">
          <figure class="m-media m-media--m m-media--contain">
            <div class="m-media__img" data-behavior="fitText">
              <div
                class="m-media__contain--spacer"
                style="padding-bottom: 62.5%"
              ></div>
              <img
                src="https://res.cloudinary.com/ds4ie2hdu/image/upload/v1674586294/Whistler2_1912_141_IRG_anno-2_wuihg2.svg"
                alt="Alt text for the second image"
                {{-- Important to include this, must be largest size available: --}}
                data-viewer-src="https://res.cloudinary.com/ds4ie2hdu/image/upload/v1674586294/Whistler2_1912_141_IRG_anno-2_wuihg2.svg"
              />
            </div>
            <figcaption>
              <div class="f-caption">Outline of hidden figure painted over</div>
            </figcaption>
          </figure>
        </div>
    </div>
    {{-- If caption of caption title --}}
    @if (isset($captionTitle))
        <div class="o-layered-image-viewer__caption">
            <div class="o-layered-image-viewer__caption-title">
                {!! $captionTitle !!}
            </div>
            @if (isset($captionText))
                <div class="o-layered-image-viewer__caption-text">
                    {!! $captionText !!}
                </div>
            @endif
        </div>
    @endif
</div>
