@if (isset($images) && !empty($images))
    @foreach ($images as $image)
        @component('components.molecules._m-layered-image-viewer-layer')
            @slot('item', $image)
        @endcomponent
    @endforeach
@endif

@if (isset($annotations) && !empty($annotations))
    @foreach ($annotations as $annotation)
        @component('components.molecules._m-layered-image-viewer-layer')
            @slot('item', $annotation)
        @endcomponent
    @endforeach
@endif


<div>
    @if (isset($captionTitle))
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
    @endif
    @if (isset($caption))
        <div class="f-caption">{!! $caption !!}</div>
    @endif
</div>


