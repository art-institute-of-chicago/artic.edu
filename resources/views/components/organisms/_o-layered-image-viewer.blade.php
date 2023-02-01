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

    @if (isset($annotations) && !empty($annotations))
        <div class="o-layered-image-viewer__annotations">
            @foreach ($annotations as $annotation)
                {{-- Repeat div for every annotation --}}
                <div class="o-layered-image-viewer__annotation">
                    @component('components.molecules._m-layered-image-viewer-layer')
                        @slot('item', $annotation)
                        @slot('size', $size)
                        @slot('layerType', 'annotation')
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
