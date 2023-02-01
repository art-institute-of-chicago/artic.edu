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
            <div class="{{ isset($caption) ? 'f-caption-title' : 'f-caption' }}">
                <div>
                    @if(isset($image['urlTitle']) && $image['urlTitle'])
                        <a href="">{!! $captionTitle !!}</a>
                    @else
                        {!! $captionTitle !!}
                    @endif
                </div>
            </div>
            <br>
        </div>
    @endif
    @if (isset($caption))
        <div class="f-caption">{!! $caption !!}</div>
    @endif


--}}

{{-- Hard coded viewer --}}
<div class="o-layered-image-viewer{{ (isset($variation)) ? ' '.$variation : '' }}" data-size="{{ (isset($images[0]['size'])) ? $images[0]['size'] : 'm' }}" data-behavior="layeredImageViewer">
    {{-- If images --}}
    <div class="o-layered-image-viewer__images">
        {{-- Repeat div for every image (figure inside is just hardcoded copy of what seems to come out of molecule) --}}
        <div class="o-layered-image-viewer__image">
            <figure class="m-media m-media--{{ (isset($images[0]['size'])) ? $images[0]['size'] : 'm' }} m-media--contain">
                <div class="m-media__img" data-behavior="fitText">
                    <div class="m-media__contain--spacer" style="padding-bottom: 62.5%"></div>
                    <img
                    src="https://res.cloudinary.com/ds4ie2hdu/image/upload/v1673265216/Whistler_1912_141_reg_NRM_adyuz9.jpg"
                    alt="The scene depicts Whistler's studio. On the left a woman reclines and appears in conversation with a passing Japanese girl holding a fan. To the right is the artist Henri Fantin-Latour looking towards the viewer, holding a palette and brushes in one hand, with a single brush poised in the other."
                    width="2000"
                    height="2614"
                    {{-- Important to include this, must be largest size available: --}}
                    data-viewer-src="https://res.cloudinary.com/ds4ie2hdu/image/upload/v1673265216/Whistler_1912_141_reg_NRM_adyuz9.jpg"
                    />
                </div>
                <figcaption>
                    <div class="f-caption">
                        Normal light
                    </div>
                </figcaption>
            </figure>
        </div>
        <div class="o-layered-image-viewer__image">
            <figure class="m-media m-media--{{ (isset($images[0]['size'])) ? $images[0]['size'] : 'm' }} m-media--contain">
                <div class="m-media__img" data-behavior="fitText">
                    <div class="m-media__contain--spacer" style="padding-bottom: 62.5%"></div>
                    <img
                    src="https://res.cloudinary.com/ds4ie2hdu/image/upload/v1675092307/Whistler_1912_141_reg_XR_eheaf9.jpg"
                    alt="The scene depicts Whistler's studio. On the left a woman reclines and appears in conversation with a passing Japanese girl holding a fan. To the right is the artist Henri Fantin-Latour looking towards the viewer, holding a palette and brushes in one hand, with a single brush poised in the other."
                    width="2000"
                    height="2614"
                    {{-- Important to include this, must be largest size available: --}}
                    data-viewer-src="https://res.cloudinary.com/ds4ie2hdu/image/upload/v1675092307/Whistler_1912_141_reg_XR_eheaf9.jpg"
                    />
                </div>
                <figcaption>
                    <div class="f-caption">
                       X-Ray
                    </div>
                </figcaption>
            </figure>
        </div>
        <div class="o-layered-image-viewer__image">
            <figure class="m-media m-media--{{ (isset($images[0]['size'])) ? $images[0]['size'] : 'm' }} m-media--contain">
                <div class="m-media__img" data-behavior="fitText">
                    <div class="m-media__contain--spacer" style="padding-bottom: 62.5%"></div>
                    <img
                    src="https://res.cloudinary.com/ds4ie2hdu/image/upload/v1675092307/Whistler_1912_141_reg_IR_uximnz.jpg"
                    alt="The scene depicts Whistler's studio. On the left a woman reclines and appears in conversation with a passing Japanese girl holding a fan. To the right is the artist Henri Fantin-Latour looking towards the viewer, holding a palette and brushes in one hand, with a single brush poised in the other."
                    width="2000"
                    height="2614"
                    {{-- Important to include this, must be largest size available: --}}
                    data-viewer-src="https://res.cloudinary.com/ds4ie2hdu/image/upload/v1675092307/Whistler_1912_141_reg_IR_uximnz.jpg"
                    />
                </div>
                <figcaption>
                    <div class="f-caption">
                        Infrared Reflectogram (1.0-1.1 µm)
                    </div>
                </figcaption>
            </figure>
        </div>
        <div class="o-layered-image-viewer__image">
            <figure class="m-media m-media--{{ (isset($images[0]['size'])) ? $images[0]['size'] : 'm' }} m-media--contain">
                <div class="m-media__img" data-behavior="fitText">
                    <div class="m-media__contain--spacer" style="padding-bottom: 62.5%"></div>
                    <img
                    src="https://res.cloudinary.com/ds4ie2hdu/image/upload/v1675092306/Whistler_1912_141_reg_IRG_eey7ud.jpg"
                    alt="The scene depicts Whistler's studio. On the left a woman reclines and appears in conversation with a passing Japanese girl holding a fan. To the right is the artist Henri Fantin-Latour looking towards the viewer, holding a palette and brushes in one hand, with a single brush poised in the other."
                    width="2000"
                    height="2614"
                    {{-- Important to include this, must be largest size available: --}}
                    data-viewer-src="https://res.cloudinary.com/ds4ie2hdu/image/upload/v1675092306/Whistler_1912_141_reg_IRG_eey7ud.jpg"
                    />
                </div>
                <figcaption>
                    <div class="f-caption">
                        Infrared Reflectogram (1.5-1.7 µm)
                    </div>
                </figcaption>
            </figure>
        </div>
        <div class="o-layered-image-viewer__image">
            <figure class="m-media m-media--{{ (isset($images[0]['size'])) ? $images[0]['size'] : 'm' }} m-media--contain">
                <div class="m-media__img" data-behavior="fitText">
                    <div class="m-media__contain--spacer" style="padding-bottom: 62.5%"></div>
                    <img
                    src="https://res.cloudinary.com/ds4ie2hdu/image/upload/v1675092307/Whistler_1912_141_reg_UV_rsgmce.jpg"
                    alt="The scene depicts Whistler's studio. On the left a woman reclines and appears in conversation with a passing Japanese girl holding a fan. To the right is the artist Henri Fantin-Latour looking towards the viewer, holding a palette and brushes in one hand, with a single brush poised in the other."
                    width="2000"
                    height="2614"
                    {{-- Important to include this, must be largest size available: --}}
                    data-viewer-src="https://res.cloudinary.com/ds4ie2hdu/image/upload/v1675092307/Whistler_1912_141_reg_UV_rsgmce.jpg"
                    />
                </div>
                <figcaption>
                    <div class="f-caption">
                        Ultraviolet
                    </div>
                </figcaption>
            </figure>
        </div>
    </div>
    {{-- If overlays --}}
    <div class="o-layered-image-viewer__overlays">
        {{-- Repeat div for every overlay --}}
        <div class="o-layered-image-viewer__overlay">
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
    <div class="o-layered-image-viewer__caption">
        <div class="o-layered-image-viewer__caption-title">
            <p>Fig 1.1</p>
        </div>
        <div class="o-layered-image-viewer__caption-text">
            <p>The Artist in His Studio,1865/66, 1895</p>
        </div>
    </div>
</div>
