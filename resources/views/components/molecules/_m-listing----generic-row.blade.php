@component('components.molecules._m-listing----generic')
    @slot('tag', $tag ?? null)
    @slot('variation', $variation ?? null)
    @slot('imgVariation', $imgVariation ?? null)
    @slot('imageSettings', $imageSettings ?? null)
    @slot('image', $image ?? null)
    @slot('item', $item)
    @slot('gtmAttributes', $gtmAttributes ?? null)
    @if(isset($date))
        @slot('date', $date)
    @endif
@endcomponent
