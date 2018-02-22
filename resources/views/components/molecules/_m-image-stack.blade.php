<span class="m-image-stack">
@foreach ($images as $image)
    <span class="m-image-stack__img">
    @component('components.atoms._img')
        @slot('image', $image)
        @slot('settings', $imageSettings ?? '')
    @endcomponent
    </span>
@endforeach
</span>
