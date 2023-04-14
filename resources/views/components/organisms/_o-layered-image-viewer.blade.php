<div class="o-layered-image-viewer{{ (isset($variation)) ? ' '.$variation : '' }}" data-size="{{ (isset($size)) ? $size : 'm' }}" {!! isset($cropRegion) ? 'data-crop-region="' . $cropRegion . '"' : '' !!} data-behavior="layeredImageViewer">
    @if (isset($images) && !empty($images))
        <div class="o-layered-image-viewer__images o-blocks__block">
            @foreach ($images as $image)
                @component('components.molecules._m-layered-image-viewer-layer')
                    @slot('item', $image)
                    @slot('size', $size)
                    @slot('layerType', 'image')
                @endcomponent
            @endforeach
        </div>
    @endif

    @if (isset($overlays) && !empty($overlays))
        <div class="o-layered-image-viewer__overlays o-blocks__block">
            @foreach ($overlays as $overlay)
                @component('components.molecules._m-layered-image-viewer-layer')
                    @slot('item', $overlay)
                    @slot('size', $size)
                    @slot('layerType', 'overlay')
                @endcomponent
            @endforeach
        </div>
    @endif

    @if (isset($captionTitle))
        <div class="o-layered-image-viewer__caption">
            <div class="o-layered-image-viewer__caption-title f-caption-title">
                {!! $captionTitle !!}
            </div>
            @if (isset($captionText))
                <div class="o-layered-image-viewer__caption-text f-caption">
                    {!! $captionText !!}
                </div>
            @endif
        </div>
    @endif
</div>
