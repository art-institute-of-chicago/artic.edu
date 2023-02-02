<div class="o-layered-image-viewer{{ (isset($variation)) ? ' '.$variation : '' }}" data-size="{{ (isset($size)) ? $size : 'm' }}" data-behavior="layeredImageViewer">
    @if (isset($images) && !empty($images))
        <div class="o-layered-image-viewer__images">
            @foreach ($images as $image)
                {{-- Repeat div for every image (figure inside is just hardcoded copy of what seems to come out of molecule) --}}
                <div class="o-layered-image-viewer__image">
                    @component('components.molecules._m-layered-image-viewer-layer')
                        @slot('item', $image)
                        @slot('size', $size)
                        @slot('layerType', 'image')
                    @endcomponent
                </div>
            @endforeach
        </div>
    @endif

    @if (isset($overlays) && !empty($overlays))
        <div class="o-layered-image-viewer__overlays">
            @foreach ($overlays as $overlay)
                {{-- Repeat div for every overlay --}}
                <div class="o-layered-image-viewer__overlay">
                    @component('components.molecules._m-layered-image-viewer-layer')
                        @slot('item', $overlay)
                        @slot('size', $size)
                        @slot('layerType', 'overlay')
                    @endcomponent
                </div>
            @endforeach
        </div>
    @endif

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
