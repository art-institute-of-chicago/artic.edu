<span class="m-image-stack">
@foreach ($images as $image)
    <span class="m-image-stack__img">
    @component('components.atoms._img')
        @slot('src', $image['src'])
        @slot('width', $image['width'])
        @slot('height', $image['height'])
    @endcomponent
    </span>
@endforeach
</span>
