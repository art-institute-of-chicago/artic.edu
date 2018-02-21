<span class="m-image-stack">
@foreach ($images as $image)
    <span class="m-image-stack__img">
    @component('components.atoms._img')
        @slot('image', $image)
        @slot('sizes', $imageSizes ?? '')
        @slot('srcset', $imageSrcSet ?? '')
    @endcomponent
    </span>
@endforeach
</span>
